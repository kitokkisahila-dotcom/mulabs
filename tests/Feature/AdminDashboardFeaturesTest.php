<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Laboratory;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_displays_management_links(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'registration_no' => 'ADM001',
            'email' => 'admin@example.com',
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('admindashboard'));

        $response->assertOk();
        $response->assertSee('Admin Portal');
        $response->assertSee('Register Department');
        $response->assertSee('Register Laboratory');
        $response->assertSee('User Management');
        $response->assertSee('Profile');
    }

    public function test_admin_and_technician_status_updates_change_the_shared_device_status(): void
    {
        $lab = Laboratory::create([
            'block_code' => 'LAB-001',
            'block_name' => 'Main Laboratory',
            'capacity' => 20,
        ]);
        $device = Device::create([
            'reg_no' => 'DEV-001',
            'device_name' => 'Microscope',
            'brand' => 'Acme',
            'block_code' => $lab->block_code,
        ]);
        $reporter = User::factory()->create(['registration_no' => 'STD001']);
        $report = Report::create([
            'device_reg_no' => $device->reg_no,
            'user_id' => $reporter->registration_no,
            'description' => 'The microscope light does not turn on.',
        ]);
        $device->syncStatusFromReports();

        $admin = User::factory()->create(['role' => 'admin', 'registration_no' => 'ADM002']);
        $this->actingAs($admin)
            ->post(route('admin.reports.toggleStatus', $report))
            ->assertRedirect(route('admindashboard'));
        $this->assertDatabaseHas('devices', ['id' => $device->id, 'status' => 'Resolved']);

        $technician = User::factory()->create(['role' => 'lab_technician', 'registration_no' => 'TECH001']);
        $this->actingAs($technician)
            ->post(route('technician.reports.toggleStatus', $report));
        $this->assertDatabaseHas('devices', ['id' => $device->id, 'status' => 'Faulty']);
    }

    public function test_technician_can_edit_and_delete_a_device(): void
    {
        $lab = Laboratory::create([
            'block_code' => 'LAB-002',
            'block_name' => 'Engineering Laboratory',
            'capacity' => 30,
        ]);
        $device = Device::create([
            'reg_no' => 'DEV-002',
            'device_name' => 'Old Device Name',
            'brand' => 'Old Brand',
            'block_code' => $lab->block_code,
        ]);
        $technician = User::factory()->create(['role' => 'lab_technician']);

        $this->actingAs($technician)
            ->put(route('technician.devices.update', $device), [
                'device_name' => 'Updated Device Name',
                'brand' => 'Updated Brand',
                'block_code' => $lab->block_code,
            ])
            ->assertRedirect(route('labtechniciandashboard'));
        $this->assertDatabaseHas('devices', [
            'id' => $device->id,
            'device_name' => 'Updated Device Name',
            'brand' => 'Updated Brand',
        ]);

        $this->delete(route('technician.devices.destroy', $device))
            ->assertRedirect(route('labtechniciandashboard'));
        $this->assertDatabaseMissing('devices', ['id' => $device->id]);
    }

    public function test_admin_can_edit_and_delete_a_department(): void
    {
        $faculty = Faculty::create(['faculty_id' => 'FAC-001', 'faculty_name' => 'Science']);
        $department = Department::create([
            'department_id' => 'DEP-001',
            'department_name' => 'Computer Science',
            'faculty_id' => $faculty->faculty_id,
        ]);
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->put(route('admin.departments.update', $department), [
                'department_id' => 'DEP-001',
                'department_name' => 'Information Technology',
                'faculty_id' => $faculty->faculty_id,
            ])
            ->assertRedirect(route('admindashboard'));

        $this->assertDatabaseHas('departments', [
            'id' => $department->id,
            'department_name' => 'Information Technology',
        ]);

        $this->delete(route('admin.departments.destroy', $department))
            ->assertRedirect(route('admindashboard'));
        $this->assertDatabaseMissing('departments', ['id' => $department->id]);
    }

    public function test_admin_user_delete_returns_json_for_in_place_dashboard_feedback(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $this->actingAs($admin)
            ->deleteJson(route('admin.users.destroy', $user))
            ->assertOk()
            ->assertJson(['message' => 'User deleted successfully']);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
