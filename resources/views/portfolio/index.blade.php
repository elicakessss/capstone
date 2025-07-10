@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Portfolio</h1>
            <p class="text-gray-600 mt-1">Manage your documents and achievements</p>
        </div>
        <button class="btn btn-green" onclick="showRequestAwardModal(event)">
            <i class="fas fa-trophy mr-2"></i>
            Request Award
        </button>
    </div>
    <div class="flex flex-col md:flex-row gap-6 mb-6">
        <!-- User Details Card (thinner, left, improved layout) -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[180px] flex flex-col items-center md:w-1/3" style="min-width:220px; max-width:340px; border-left: 5px solid #00471B;">
            @if(auth()->user()->profile_picture)
                <img src="{{ \Illuminate\Support\Facades\Storage::url(auth()->user()->profile_picture) }}" alt="Profile Picture" class="w-20 h-20 rounded-full object-cover mb-3 shadow">
            @else
                <div class="w-20 h-20 rounded-full flex items-center justify-center bg-green-100 text-green-800 text-3xl font-bold mb-3 shadow">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            <div class="text-center w-full">
                <div class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</div>
                <div class="text-sm text-gray-600 mb-1">{{ auth()->user()->email }}</div>
                @if(auth()->user()->bio)
                    <div class="text-xs text-gray-500 mb-2 text-justify">{{ auth()->user()->bio }}</div>
                @endif
            </div>
            <div class="w-full border-b border-gray-200 my-3"></div>
            <div class="w-full">
                <ul class="list-disc ml-6 text-gray-700 text-sm">
                    @forelse($orgPositions as $item)
                        <li>
                            <span class="font-medium">{{ $item['org'] }}</span>
                            <span class="text-gray-500">({{ $item['academic_year'] }})</span>
                            — <span class="text-green-900 font-semibold">{{ $item['role'] }}</span>
                        </li>
                    @empty
                        <li class="text-gray-400">No organizations yet.</li>
                    @endforelse
                </ul>
            </div>
            <div class="flex-1"></div>
            <div class="w-full border-b border-gray-200 my-3"></div>
            <div class="w-full flex justify-center">
                <a href="#" class="btn btn-white text-gray-700 border border-gray-200 shadow-sm mt-1" onclick="showEditProfileModal(event)"><i class="fas fa-edit mr-1"></i> Edit Profile</a>
            </div>
        </div>
        <!-- Right Column: Org Terms Served + Certificate Upload stacked -->
        <div class="flex flex-col gap-6 flex-1">
            <!-- Organization Terms Served Card (wider, right) -->
            <div class="bg-white rounded-lg shadow p-6 min-h-[180px] flex flex-col justify-between">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Organization Terms Served</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                    @forelse($orgPositions as $item)
                        <div class="org-card bg-white rounded-lg shadow-sm p-4 flex items-center gap-4 transition-transform duration-200 cursor-pointer min-h-[100px]"
                            style="border-left: 6px solid #00471B; border-top: 1.5px solid #f3f4f6; border-bottom: 1.5px solid #f3f4f6; border-right: 1.5px solid #f3f4f6; border-radius: 0.75rem;"
                            >
                            @if(!empty($item['logo']))
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($item['logo']) }}" alt="{{ $item['org'] }} Logo" class="w-14 h-14 rounded-full object-cover border border-gray-200 shadow-sm">
                            @else
                                <div class="w-14 h-14 rounded-full flex items-center justify-center bg-green-100 text-green-800 text-2xl font-bold border border-gray-200 shadow-sm">
                                    <i class="fas fa-users"></i>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h2 class="org-title truncate font-semibold text-base text-gray-900 mb-1">{{ $item['org'] }}</h2>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="org-type text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">Role: {{ $item['role'] }}</span>
                                </div>
                                <span class="org-term text-xs text-green-700 bg-green-100 px-2 py-0.5 rounded">{{ $item['academic_year'] }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center text-gray-500 py-8">No organizations served yet.</div>
                    @endforelse
                </div>
            </div>
            <!-- Certificate Upload Card (stacked below org terms) -->
            <div class="bg-white rounded-lg shadow p-6 min-h-[220px] flex flex-col justify-between">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-lg font-semibold text-gray-900">Awards & Certificates</h2>
                    <button class="btn btn-green w-fit" onclick="showAwardModal(event)"><i class="fas fa-plus mr-2"></i>Upload</button>
                </div>
                <div class="mt-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($awards as $award)
                            <div class="relative bg-gray-50 rounded-lg shadow-md p-4 flex flex-col items-center border border-gray-200 group transition-all duration-300" data-award-id="{{ $award->id }}">
                                <button class="absolute top-2 right-2 text-gray-400 hover:text-red-600 bg-white rounded-full p-1 shadow transition" onclick="deleteAward({{ $award->id }})"><i class="fas fa-times"></i></button>
                                @php
                                    $ext = strtolower(pathinfo($award->file_path, PATHINFO_EXTENSION));
                                    $url = Storage::disk('public')->url($award->file_path);
                                    $thumb = $award->thumbnail_path ? \Illuminate\Support\Facades\Storage::url($award->thumbnail_path) : null;
                                @endphp
                                @if($thumb)
                                    <img src="{{ $thumb }}" alt="Certificate Thumbnail" class="w-full h-40 object-contain rounded mb-3 bg-white border" />
                                @elseif(in_array($ext, ['jpg','jpeg','png','gif','webp','bmp']))
                                    <img src="{{ $url }}" alt="Certificate Image" class="w-full h-40 object-contain rounded mb-3 bg-white border" />
                                @elseif($ext === 'pdf')
                                    <div class="w-full h-40 mb-3 flex items-center justify-center bg-white border rounded overflow-hidden">
                                        <i class="fas fa-file-pdf fa-3x text-red-500"></i>
                                    </div>
                                @else
                                    <div class="w-full h-40 flex items-center justify-center bg-gray-100 text-gray-400 rounded mb-3">
                                        <i class="fas fa-file fa-3x"></i>
                                    </div>
                                @endif
                                <div class="w-full text-center mb-2 truncate text-xs text-gray-700 font-semibold">{{ $award->name }}</div>
                                <div class="flex gap-2 justify-center w-full">
                                    <a href="{{ $url }}" download class="btn btn-xs btn-gray"><i class="fas fa-download mr-1"></i>Download</a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center text-gray-400">No awards or certificates uploaded yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
            <!-- Award Upload Modal -->
            <div id="awardModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
                    <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
                        <h3 class="text-lg font-semibold text-white">Upload Certificate/Award</h3>
                        <button onclick="hideAwardModal()" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('portfolio.awards.store') }}" class="px-6 pt-6 pb-2" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label text-base mb-1">Certificate Name</label>
                            <input type="text" name="name" class="form-input w-full text-base" maxlength="255" required />
                        </div>
                        <div class="mb-4 flex flex-row gap-4 items-start">
                            <div class="flex-1 flex flex-col items-center">
                                <label class="form-label text-base mb-1">Thumbnail</label>
                                <button type="button" onclick="document.getElementById('awardThumbnailInput').click();" class="btn btn-green flex items-center gap-2 mb-2">
                                    <i class="fas fa-upload"></i> <span>Choose Thumbnail</span>
                                </button>
                                <input id="awardThumbnailInput" type="file" name="thumbnail" accept="image/*" class="hidden" onchange="showThumbnailIndicator(event)">
                                <div id="thumbnailIndicator" class="text-green-700 text-xs mt-1 hidden"><i class="fas fa-check-circle mr-1"></i>Thumbnail selected</div>
                            </div>
                            <div class="flex-1 flex flex-col items-center">
                                <label class="form-label text-base mb-1">Certificate File</label>
                                <button type="button" onclick="document.getElementById('awardCertificateInput').click();" class="btn btn-green flex items-center gap-2 mb-2">
                                    <i class="fas fa-upload"></i> <span>Choose File</span>
                                </button>
                                <input id="awardCertificateInput" type="file" name="certificate" accept="application/pdf,image/*" class="hidden" required onchange="showCertificateIndicator(event)">
                                <div id="certificateIndicator" class="text-green-700 text-xs mt-1 hidden"><i class="fas fa-check-circle mr-1"></i>File selected</div>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                            <button type="button" onclick="hideAwardModal()" class="btn btn-gray">Cancel</button>
                            <button type="submit" class="btn btn-green">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Request Award Modal -->
            <div id="requestAwardModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
                    <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
                        <h3 class="text-lg font-semibold text-white">Request Award</h3>
                        <button onclick="hideRequestAwardModal()" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('portfolio.requestAward') }}" class="px-6 pt-6 pb-2">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label text-base mb-1">Award Type</label>
                            <select name="award_type_id" class="form-select w-full text-base" required>
                                <option value="">Select Award</option>
                                @foreach($orgPositions as $item)
                                    @php
                                        $org = \App\Models\Org::where('name', $item['org'])->first();
                                        if($org) {
                                            $awardTypes = $org->awardTypes ?? collect();
                                            foreach($awardTypes as $awardType) {
                                                echo '<option value="'.$awardType->id.'" data-org="'.$org->id.'">'.$awardType->name.' ('.$item['org'].')</option>';
                                            }
                                        }
                                    @endphp
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_graduating" class="mr-2" required>
                                <span>I confirm I am graduating</span>
                            </label>
                        </div>
                        <input type="hidden" name="org_id" id="requestAwardOrgId" value="">
                        <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                            <button type="button" onclick="hideRequestAwardModal()" class="btn btn-gray">Cancel</button>
                            <button type="submit" class="btn btn-green">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
            function showAwardModal(e) {
                e.preventDefault();
                document.getElementById('awardModal').classList.remove('hidden');
            }
            function hideAwardModal() {
                document.getElementById('awardModal').classList.add('hidden');
            }
            function deleteAward(id) {
                if(confirm('Delete this award?')) {
                    const card = document.querySelector(`[data-award-id='${id}']`);
                    fetch(`{{ url('portfolio/awards') }}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    }).then(async res => {
                        if(res.ok) {
                            if(card) card.remove();
                            showToast('Award deleted successfully.', 'success');
                        } else {
                            const text = await res.text();
                            showToast('Delete failed: ' + res.status, 'error');
                        }
                    }).catch(err => {
                        showToast('Network error', 'error');
                    });
                }
            }
            function showToast(msg, type = 'success') {
                let toast = document.createElement('div');
                toast.className = `fixed bottom-6 right-6 bg-${type === 'success' ? 'green' : 'red'}-700 text-white px-4 py-2 rounded shadow-lg z-50 animate-fadein`;
                toast.innerText = msg;
                document.body.appendChild(toast);
                setTimeout(() => {
                    toast.classList.add('opacity-0');
                    setTimeout(() => toast.remove(), 500);
                }, 2000);
            }
            function showThumbnailIndicator(event) {
                const indicator = document.getElementById('thumbnailIndicator');
                if(event.target.files && event.target.files.length > 0) {
                    indicator.classList.remove('hidden');
                } else {
                    indicator.classList.add('hidden');
                }
            }
            function showCertificateIndicator(event) {
                const indicator = document.getElementById('certificateIndicator');
                if(event.target.files && event.target.files.length > 0) {
                    indicator.classList.remove('hidden');
                } else {
                    indicator.classList.add('hidden');
                }
            }
            function showRequestAwardModal(e) {
                e.preventDefault();
                document.getElementById('requestAwardModal').classList.remove('hidden');
            }
            function hideRequestAwardModal() {
                document.getElementById('requestAwardModal').classList.add('hidden');
            }
            // Set org_id based on selected award type
            document.addEventListener('DOMContentLoaded', function() {
                const select = document.querySelector('#requestAwardModal select[name="award_type_id"]');
                const orgInput = document.getElementById('requestAwardOrgId');
                if(select && orgInput) {
                    select.addEventListener('change', function() {
                        const selected = select.options[select.selectedIndex];
                        orgInput.value = selected.getAttribute('data-org') || '';
                    });
                }
            });
            </script>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
            <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
                <h3 class="text-lg font-semibold text-white">Edit Profile</h3>
                <button onclick="hideEditProfileModal()" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('profile.update') }}" class="px-6 pt-6 pb-2" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4 flex flex-col items-center">
                    <label class="form-label text-base mb-1">Profile Picture</label>
                    <button type="button" onclick="document.getElementById('editProfilePicInput').click();" class="btn btn-green flex items-center gap-2 mb-2">
                        <i class="fas fa-upload"></i> <span>Choose Picture</span>
                    </button>
                    <input id="editProfilePicInput" type="file" name="profile_picture" accept="image/*" class="hidden" onchange="previewEditProfilePic(event)">
                    <div id="editProfilePicPreviewWrapper" class="mb-2" style="display:{{ auth()->user()->profile_picture ? 'block' : 'none' }};">
                        <img id="editProfilePicPreview" src="{{ auth()->user()->profile_picture ? \Illuminate\Support\Facades\Storage::url(auth()->user()->profile_picture) : '#' }}" alt="Profile Picture Preview" class="w-20 h-20 rounded-full object-cover border border-gray-200 shadow mb-2 mx-auto" style="max-width:80px; max-height:80px;" />
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label text-base">Bio / Description</label>
                    <textarea name="bio" class="form-input w-full text-base" rows="3" maxlength="255">{{ old('bio', auth()->user()->bio) }}</textarea>
                </div>
                <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                    <button type="button" onclick="hideEditProfileModal()" class="btn btn-gray">Cancel</button>
                    <button type="submit" class="btn btn-green">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <script>
    function showEditProfileModal(e) {
        e.preventDefault();
        document.getElementById('editProfileModal').classList.remove('hidden');
    }
    function hideEditProfileModal() {
        document.getElementById('editProfileModal').classList.add('hidden');
    }
    function previewEditProfilePic(event) {
        const input = event.target;
        const previewWrapper = document.getElementById('editProfilePicPreviewWrapper');
        const preview = document.getElementById('editProfilePicPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewWrapper.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            previewWrapper.style.display = 'none';
        }
    }
    </script>
</div>

<!-- Add this CSS for smooth fade/scale transition and toast animation -->
<style>
[data-award-id] {
    transition: opacity 0.3s, transform 0.3s;
}
.animate-fadein {
    animation: fadein 0.3s;
}
@keyframes fadein {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
#awardModal .form-input,
#awardModal .form-label,
#editProfileModal .form-input,
#editProfileModal .form-label {
    font-size: 14px !important;
}
</style>
@endsection
