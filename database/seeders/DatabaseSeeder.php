<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── 1. USER ACCOUNTS ───────────────────────────────────────────────────
        
        // Admin Account
        $admin = User::updateOrCreate(
            ['email' => 'admin@hyperedge.com'],
            [
                'first_name'        => 'HyperEdge',
                'last_name'         => 'Admin',
                'password'          => Hash::make('admin123'),
                'role'              => 'admin',
                'email_verified'    => true,
                'email_verified_at' => now(),
                'is_active'         => true,
            ]
        );
        $this->command->info('Admin seeded: admin@hyperedge.com / admin123');

        // Facilitator Account
        $teacher = User::updateOrCreate(
            ['email' => 'teacher@hyperedge.com'],
            [
                'first_name'        => 'Professor',
                'last_name'         => 'Oak',
                'password'          => Hash::make('teacher123'),
                'role'              => 'teacher',
                'email_verified'    => true,
                'email_verified_at' => now(),
                'is_active'         => true,
            ]
        );
        $this->command->info('Facilitator seeded: teacher@hyperedge.com / teacher123');

        // Student 1: Approved Voucher (Instant Access)
        $studentApproved = User::updateOrCreate(
            ['email' => 'student@hyperedge.com'],
            [
                'first_name'        => 'Juan',
                'last_name'         => 'Dela Cruz',
                'password'          => Hash::make('student123'),
                'role'              => 'student',
                'email_verified'    => true,
                'email_verified_at' => now(),
                'is_active'         => true,
            ]
        );
        $this->command->info('Student (Approved) seeded: student@hyperedge.com / student123');

        // Student 2: Pending Approval (Review Flow testing)
        $studentPending = User::updateOrCreate(
            ['email' => 'newstudent@hyperedge.com'],
            [
                'first_name'        => 'Maria',
                'last_name'         => 'Clara',
                'password'          => Hash::make('student123'),
                'role'              => 'student',
                'email_verified'    => true,
                'email_verified_at' => now(),
                'is_active'         => true,
            ]
        );
        $this->command->info('Student (Pending Review) seeded: newstudent@hyperedge.com / student123');


        // ─── 2. VOUCHER STATES ──────────────────────────────────────────────────

        // Voucher 1: Pre-approved for instant student coursework access
        Voucher::updateOrCreate(
            ['code' => 'APPROVED123'],
            [
                'generated_by' => $admin->id,
                'assigned_to'  => $studentApproved->id,
                'is_used'      => true,
                'is_paid'      => true,
                'is_approved'  => true,
                'approved_at'  => now(),
                'used_at'      => now(),
                'notes'        => 'Scholarship voucher pre-approved.',
            ]
        );

        // Voucher 2: Uploaded payment proof for manual Admin Approval Flow testing
        Voucher::updateOrCreate(
            ['code' => 'PENDING456'],
            [
                'generated_by' => $admin->id,
                'assigned_to'  => $studentPending->id,
                'is_used'      => true,
                'is_paid'      => true,
                'is_approved'  => false,
                'payment_proof'=> 'payment_proofs/sample_receipt.jpg', // dummy path for modal render
                'notes'        => 'Paid via Bank Transfer. Reference ID: BK-9827415-X.',
            ]
        );


        // ─── 3. DELEGATE TO REAL COURSE CONTENT SEEDER ─────────────────────────
        $this->call(RealCourseContentSeeder::class);

        $this->command->info('Database seeding completed perfectly! Ready to roll.');
    }
}
