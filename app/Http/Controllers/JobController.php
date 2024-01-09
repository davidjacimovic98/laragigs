<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    // All jobs
    public function index() {
        // dd(request());
        return view('jobs.index', [
            'jobs' => Job::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    // Single job
    public function show(Job $job) {
        return view('jobs.show', [
            'job' => $job
        ]);
    }

    // Show create form
    public function create() {
        return view('jobs.create');
    }

    // Store new job data
    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('jobs', 'company')],
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'description' => 'required',
            'tags' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id']=auth()->id();

        Job::create($formFields);

        return redirect('/')->with('message', 'Job posted successfully!');
    }

    // Show edit form
    public function edit(Job $job) {
        return view('jobs.edit', ['job' => $job]);
    }

     // Update job data
     public function update(Request $request, Job $job) {

        // Make sure that logged in user is owner of job
        if($job->user_id != auth()->id()) {
            abort(403, 'Unauthorized action!');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'description' => 'required',
            'tags' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $job->update($formFields);

        return back()->with('message', 'Job updated successfully!');
    }

    // Delete job
    public function destroy(Job $job) {
        // Make sure that logged in user is owner of job
        if($job->user_id != auth()->id()) {
            abort(403, 'Unauthorized action!');
        }
        
        $job->delete();

        return redirect('/')->with('message', 'Job deleted successfully!');
    }

    // Manage jobs
    public function manage() {
        return view('jobs.manage', [
            'jobs' => auth()->user()->jobs()->get()
        ]);
    }
}
