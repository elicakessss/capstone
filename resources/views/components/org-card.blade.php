<div class="bg-white rounded-lg shadow-md border-l-4 flex flex-col justify-between p-5 mb-4" style="border-left-color: {{ $borderColor ?? '#3B82F6' }}; min-width: 220px;">
    <div class="flex items-center mb-2">
        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full {{ $iconBg ?? 'bg-blue-100' }} mr-3">
            <i class="{{ $icon ?? 'fas fa-users' }} {{ $iconColor ?? 'text-blue-600' }} text-xl"></i>
        </div>
        <div>
            <div class="font-bold text-lg text-gray-900">{{ $orgName }}</div>
            <div class="text-sm text-gray-500">{{ $academicYear }}</div>
        </div>
    </div>
</div>
