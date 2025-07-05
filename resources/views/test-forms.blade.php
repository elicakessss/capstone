@extends('layouts.app')

@section('title', 'Form Components Test')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Form Components Test</h1>
                <p class="text-gray-600 mt-1">Testing all reusable form components with SPUP design system</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-yellow-100 rounded-full flex items-center justify-center border-2" style="border-color: #FFCC00;">
                    <i class="fas fa-clipboard-list text-2xl" style="color: #00471B;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Basic Form Components -->
    <x-form-card title="Basic Form Components" subtitle="Input fields, selects, and text areas" border-color="#00471B">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-form-input
                name="first_name"
                label="First Name"
                placeholder="Enter your first name"
                :required="true"
            />

            <x-form-input
                name="last_name"
                label="Last Name"
                placeholder="Enter your last name"
                :required="true"
            />

            <x-form-input
                name="email"
                type="email"
                label="Email Address"
                placeholder="Enter your email address"
                :required="true"
            />

            <x-form-input
                name="phone"
                type="tel"
                label="Phone Number"
                placeholder="Enter your phone number"
            />
        </div>

        <x-form-select
            name="department"
            label="Department"
            placeholder="Select your department"
            :required="true"
            :options="[
                'coe' => 'College of Engineering',
                'cba' => 'College of Business Administration',
                'cas' => 'College of Arts and Sciences',
                'cte' => 'College of Teacher Education',
                'ccs' => 'College of Computer Studies'
            ]"
        />

        <x-form-textarea
            name="bio"
            label="Biography"
            placeholder="Tell us about yourself..."
            :rows="4"
        />
    </x-form-card>

    <!-- File Upload Components -->
    <x-form-card title="File Upload Components" subtitle="Document and image upload fields" border-color="#FFCC00">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-form-file
                name="profile_picture"
                label="Profile Picture"
                placeholder="Upload your profile picture"
                accept="Images (JPG, PNG, GIF)"
            />

            <x-form-file
                name="resume"
                label="Resume/CV"
                placeholder="Upload your resume"
                accept="PDF, DOC, DOCX files"
                :required="true"
            />
        </div>
    </x-form-card>

    <!-- Button Components -->
    <x-form-card title="Button Components" subtitle="Various button styles and variants" border-color="#00471B">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <x-form-button variant="primary" icon="fas fa-save">
                Save
            </x-form-button>

            <x-form-button variant="secondary" icon="fas fa-times">
                Cancel
            </x-form-button>

            <x-form-button variant="success" icon="fas fa-check">
                Submit
            </x-form-button>

            <x-form-button variant="warning" icon="fas fa-exclamation-triangle">
                Warning
            </x-form-button>

            <x-form-button variant="danger" icon="fas fa-trash">
                Delete
            </x-form-button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4">
            <x-form-button variant="primary" size="sm" icon="fas fa-plus">
                Small Button
            </x-form-button>

            <x-form-button variant="primary" size="md" icon="fas fa-edit">
                Medium Button
            </x-form-button>

            <x-form-button variant="primary" size="lg" icon="fas fa-rocket">
                Large Button
            </x-form-button>
        </div>
    </x-form-card>

    <!-- Complete Form Example -->
    <x-form-card title="Complete Form Example" subtitle="Student portfolio information form" border-color="#00471B">
        <form method="POST" action="#" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Personal Information -->
            <div>
                <h3 class="text-lg font-semibold mb-4" style="color: #00471B;">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-form-input
                        name="student_id"
                        label="Student ID"
                        placeholder="Enter student ID"
                        :required="true"
                    />

                    <x-form-input
                        name="year_level"
                        label="Year Level"
                        placeholder="e.g., 3rd Year"
                        :required="true"
                    />

                    <x-form-select
                        name="course"
                        label="Course"
                        placeholder="Select your course"
                        :required="true"
                        :options="[
                            'bsit' => 'BS Information Technology',
                            'bscs' => 'BS Computer Science',
                            'bsba' => 'BS Business Administration',
                            'bsed' => 'BS Education',
                            'bsce' => 'BS Civil Engineering'
                        ]"
                    />

                    <x-form-select
                        name="organization"
                        label="Primary Organization"
                        placeholder="Select organization"
                        :options="[
                            'csg' => 'College Student Government',
                            'acm' => 'ACM Student Chapter',
                            'ieee' => 'IEEE Student Branch',
                            'rotaract' => 'Rotaract Club'
                        ]"
                    />
                </div>
            </div>

            <!-- Portfolio Details -->
            <div>
                <h3 class="text-lg font-semibold mb-4" style="color: #00471B;">Portfolio Details</h3>
                <div class="space-y-6">
                    <x-form-textarea
                        name="achievements"
                        label="Major Achievements"
                        placeholder="List your major achievements and accomplishments..."
                        :rows="4"
                        :required="true"
                    />

                    <x-form-textarea
                        name="goals"
                        label="Academic Goals"
                        placeholder="Describe your academic and career goals..."
                        :rows="3"
                    />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-form-file
                            name="certificate"
                            label="Certificates"
                            placeholder="Upload certificates"
                            accept="PDF, JPG, PNG files"
                        />

                        <x-form-file
                            name="portfolio_documents"
                            label="Portfolio Documents"
                            placeholder="Upload portfolio documents"
                            accept="PDF, DOC, DOCX files"
                        />
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <x-form-button type="submit" variant="primary" icon="fas fa-save" class="flex-1 sm:flex-none">
                    Save Portfolio
                </x-form-button>

                <x-form-button type="button" variant="secondary" icon="fas fa-eye" class="flex-1 sm:flex-none">
                    Preview
                </x-form-button>

                <x-form-button type="reset" variant="warning" icon="fas fa-undo" class="flex-1 sm:flex-none">
                    Reset Form
                </x-form-button>
            </div>
        </form>
    </x-form-card>

    <!-- Component Usage Guide -->
    <x-form-card title="Component Usage Guide" subtitle="How to use these components in your forms" border-color="#FFCC00">
        <div class="space-y-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-medium text-gray-900 mb-2">Form Card</h4>
                <code class="text-sm text-gray-700">
                    &lt;x-form-card title="Form Title" subtitle="Description" border-color="#00471B"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<!-- Form content --><br>
                    &lt;/x-form-card&gt;
                </code>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-medium text-gray-900 mb-2">Form Input</h4>
                <code class="text-sm text-gray-700">
                    &lt;x-form-input name="field_name" label="Field Label" placeholder="Enter value" :required="true" /&gt;
                </code>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-medium text-gray-900 mb-2">Form Button</h4>
                <code class="text-sm text-gray-700">
                    &lt;x-form-button variant="primary" icon="fas fa-save"&gt;Save&lt;/x-form-button&gt;
                </code>
            </div>
        </div>
    </x-form-card>
</div>
@endsection
