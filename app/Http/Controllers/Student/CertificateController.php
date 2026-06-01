<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index()
    {
        $certificate = Auth::user()->certificate;
        return view('student.certificate', compact('certificate'));
    }
}