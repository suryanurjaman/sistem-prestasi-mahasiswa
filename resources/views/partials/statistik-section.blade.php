<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab"
        data-tabs-toggle="#default-styled-tab-content"
        data-tabs-active-classes="text-purple-700 hover:text-purple-700 dark:text-purple-500 dark:hover:text-purple-500 border-purple-700 dark:border-purple-500"
        data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300"
        role="tablist">
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2  rounded-t-lg" id="profile-tab" data-tabs-target="#profile"
                type="button" role="tab" aria-controls="profile" aria-selected="true">Fakultas</button>
        </li>
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2  rounded-t-lg" id="dashboard-tab" data-tabs-target="#dashboard"
                type="button" role="tab" aria-controls="dashboard" aria-selected="false">Prodi</button>
        </li>
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2  rounded-t-lg" id="settings-tab" data-tabs-target="#settings"
                type="button" role="tab" aria-controls="settings" aria-selected="false">Ormawa</button>
        </li>
        <li role="presentation">
            <button class="inline-block p-4 border-b-2  rounded-t-lg" id="contacts-tab" data-tabs-target="#contacts"
                type="button" role="tab" aria-controls="contacts" aria-selected="false">Tahun</button>
        </li>
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2  rounded-t-lg" id="ukm-tab" data-tabs-target="#ukm"
                type="button" role="tab" aria-controls="ukm" aria-selected="false">UKM</button>
        </li>
    </ul>
</div>

<div id="default-tab-content">
    <div class="flex flex-col lg:flex-row gap-6" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="w-full lg:w-1/2 bg-gray-50 p-4 rounded-lg shadow-md">
            <canvas id="chartFakultas"></canvas>
        </div>
        <x-stat-table :data="$fakultasCounts" label="Fakultas" />
    </div>

    <div class="flex flex-col lg:flex-row gap-6" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
        <div class="w-full lg:w-1/2 bg-gray-50 p-4 rounded-lg shadow-md">
            <canvas id="chartProdi"></canvas>
        </div>
        <x-stat-table :data="$prodiCounts" label="Prodi" />
    </div>

    <div class="flex flex-col lg:flex-row gap-6" id="settings" role="tabpanel" aria-labelledby="settings-tab">
        <div class="w-full lg:w-1/2 bg-gray-50 p-4 rounded-lg shadow-md">
            <canvas id="chartOrmawa"></canvas>
        </div>
        <x-stat-table :data="$ormawaCounts" label="Ormawa" />
    </div>

    <div class="flex flex-col lg:flex-row gap-6" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
        <div class="w-full lg:w-1/2 bg-gray-50 p-4 rounded-lg shadow-md">
            <canvas id="chartTahun"></canvas>
        </div>
        <x-stat-table :data="$tahunCounts" label="Tahun" />
    </div>

    <div class="flex flex-col lg:flex-row gap-6" id="ukm" role="tabpanel" aria-labelledby="ukm-tab">
        <div class="w-full lg:w-1/2 bg-gray-50 p-4 rounded-lg shadow-md">
            <canvas id="chartUKM"></canvas>
        </div>
        <x-stat-table :data="$ukmCounts" label="UKM" />
    </div>
</div>
