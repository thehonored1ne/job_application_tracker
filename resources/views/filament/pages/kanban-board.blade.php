<x-filament-panels::page>
    <style>
        .kanban-toolbar {
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding: 18px 20px;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            margin-bottom: 16px;
        }
        .dark .kanban-toolbar {
            background: #0f172a;
            border-color: #1e293b;
        }
        .kanban-toolbar-top {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .kanban-stage-tabs {
            display: inline-flex;
            background: #f1f5f9;
            padding: 4px;
            border-radius: 8px;
            gap: 4px;
        }
        .dark .kanban-stage-tabs {
            background: #1e293b;
        }
        .kanban-tab-btn {
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            border: none;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .dark .kanban-tab-btn {
            color: #94a3b8;
        }
        .kanban-tab-btn.active {
            background: #ffffff;
            color: #0f172a;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.06);
        }
        .dark .kanban-tab-btn.active {
            background: #334155;
            color: #f8fafc;
        }
        .kanban-scroll-nav {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .kanban-nav-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #475569;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .dark .kanban-nav-btn {
            background: #1e293b;
            border-color: #334155;
            color: #cbd5e1;
        }
        .kanban-nav-btn:hover {
            border-color: #6366f1;
            color: #6366f1;
            background: #f8fafc;
        }
        .dark .kanban-nav-btn:hover {
            background: #0f172a;
        }
        .kanban-filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 14px;
            align-items: flex-end;
        }
        .kanban-filter-group label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 6px;
        }
        .dark .kanban-filter-group label {
            color: #94a3b8;
        }
        .kanban-input, .kanban-select {
            width: 100%;
            height: 38px;
            padding: 6px 12px;
            font-size: 13px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #0f172a;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        .dark .kanban-input, .dark .kanban-select {
            background: #1e293b;
            border-color: #334155;
            color: #f8fafc;
        }
        .kanban-input:focus, .kanban-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }
        .kanban-btn-create {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            height: 38px;
            padding: 0 16px;
            font-size: 13px;
            font-weight: 600;
            color: #ffffff;
            background: #6366f1;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.15s ease;
        }
        .kanban-btn-create:hover {
            background: #4f46e5;
        }
        .kanban-board-container {
            position: relative;
            width: 100%;
        }
        .kanban-board {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            padding: 8px 4px 24px 4px;
            min-height: 720px;
            align-items: flex-start;
            scrollbar-width: thin;
            scrollbar-color: #94a3b8 #f1f5f9;
        }
        .dark .kanban-board {
            scrollbar-color: #475569 #0f172a;
        }
        .kanban-board::-webkit-scrollbar {
            height: 10px;
        }
        .kanban-board::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 6px;
        }
        .dark .kanban-board::-webkit-scrollbar-track {
            background: #1e293b;
        }
        .kanban-board::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 6px;
        }
        .kanban-board::-webkit-scrollbar-thumb:hover {
            background: #6366f1;
        }
        .kanban-column {
            flex: 0 0 290px;
            width: 290px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            max-height: 820px;
            transition: border-color 0.2s ease;
        }
        .dark .kanban-column {
            background: #0f172a;
            border-color: #1e293b;
        }
        .kanban-column-header {
            padding: 12px 14px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dark .kanban-column-header {
            background: #1e293b;
            border-bottom-color: #334155;
        }
        .kanban-stage-pill {
            display: inline-flex;
            align-items: center;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .stage-gray { background: #f1f5f9; color: #475569; }
        .dark .stage-gray { background: #334155; color: #cbd5e1; }
        .stage-info { background: #e0f2fe; color: #0369a1; }
        .dark .stage-info { background: #0c4a6e; color: #7dd3fc; }
        .stage-warning { background: #fef3c7; color: #b45309; }
        .dark .stage-warning { background: #78350f; color: #fde68a; }
        .stage-purple { background: #f3e8ff; color: #7e22ce; }
        .dark .stage-purple { background: #581c87; color: #d8b4fe; }
        .stage-cyan { background: #cffafe; color: #0e7490; }
        .dark .stage-cyan { background: #164e63; color: #67e8f9; }
        .stage-orange { background: #ffedd5; color: #c2410c; }
        .dark .stage-orange { background: #7c2d12; color: #fdba74; }
        .stage-success { background: #dcfce7; color: #15803d; }
        .dark .stage-success { background: #14532d; color: #86efac; }
        .stage-danger { background: #ffe4e6; color: #be123c; }
        .dark .stage-danger { background: #881337; color: #fda4af; }

        .kanban-count-pill {
            font-size: 11px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 999px;
            background: #e2e8f0;
            color: #475569;
        }
        .dark .kanban-count-pill {
            background: #334155;
            color: #94a3b8;
        }
        .kanban-card-list {
            padding: 12px;
            overflow-y: auto;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
            min-height: 140px;
        }
        .kanban-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            cursor: grab;
            transition: all 0.15s ease-in-out;
        }
        .dark .kanban-card {
            background: #1e293b;
            border-color: #334155;
        }
        .kanban-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: #818cf8;
        }
        .kanban-card:active {
            cursor: grabbing;
        }
        .kanban-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .kanban-company-info {
            display: flex;
            align-items: center;
            gap: 8px;
            overflow: hidden;
        }
        .kanban-company-avatar {
            width: 22px;
            height: 22px;
            border-radius: 999px;
            background: #e0e7ff;
            color: #4338ca;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            flex-shrink: 0;
        }
        .dark .kanban-company-avatar {
            background: #312e81;
            color: #a5b4fc;
        }
        .kanban-company-name {
            font-size: 12px;
            font-weight: 700;
            color: #334155;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .dark .kanban-company-name {
            color: #cbd5e1;
        }
        .kanban-priority-stars {
            font-size: 12px;
            color: #f59e0b;
            letter-spacing: -1px;
            font-weight: 700;
        }
        .kanban-job-title {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            text-decoration: none;
            margin-bottom: 8px;
            line-height: 1.35;
        }
        .dark .kanban-job-title {
            color: #f8fafc;
        }
        .kanban-job-title:hover {
            color: #6366f1;
        }
        .kanban-tag-row {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 10px;
        }
        .kanban-tag {
            font-size: 10px;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 4px;
            background: #f1f5f9;
            color: #475569;
        }
        .dark .kanban-tag {
            background: #334155;
            color: #cbd5e1;
        }
        .kanban-tag-blue {
            background: #eff6ff;
            color: #1d4ed8;
        }
        .dark .kanban-tag-blue {
            background: #1e3a8a;
            color: #93c5fd;
        }
        .kanban-salary {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 10px;
        }
        .dark .kanban-salary {
            color: #94a3b8;
        }
        .kanban-salary-offer {
            color: #16a34a;
            font-weight: 700;
        }
        .dark .kanban-salary-offer {
            color: #4ade80;
        }
        .kanban-interview-alert {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 6px;
            padding: 8px 10px;
            font-size: 11px;
            color: #92400e;
            margin-bottom: 10px;
        }
        .dark .kanban-interview-alert {
            background: #451a03;
            border-color: #78350f;
            color: #fde68a;
        }
        .kanban-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 8px;
            border-top: 1px solid #f1f5f9;
            font-size: 11px;
            color: #64748b;
        }
        .dark .kanban-card-footer {
            border-top-color: #334155;
            color: #94a3b8;
        }
        .kanban-move-select {
            font-size: 11px;
            padding: 3px 6px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            color: #334155;
            outline: none;
        }
        .dark .kanban-move-select {
            background: #0f172a;
            border-color: #334155;
            color: #cbd5e1;
        }
        .kanban-empty-col {
            padding: 24px 12px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            font-style: italic;
        }
    </style>

    <div
        x-data="{
            draggingId: null,
            scrollBoard(amount) {
                if (this.$refs.boardContainer) {
                    this.$refs.boardContainer.scrollBy({ left: amount, behavior: 'smooth' });
                }
            },
            dragStart(event, id) {
                this.draggingId = id;
                event.dataTransfer.effectAllowed = 'move';
                event.dataTransfer.setData('text/plain', id);
            },
            dragOver(event) {
                event.preventDefault();
                event.dataTransfer.dropEffect = 'move';
            },
            drop(event, targetStatus) {
                event.preventDefault();
                if (this.draggingId) {
                    $wire.updateApplicationStatus(this.draggingId, targetStatus);
                    this.draggingId = null;
                }
            }
        }"
    >
        {{-- Search, Filters & Stage Group Tabs Bar --}}
        <div class="kanban-toolbar">
            <div class="kanban-toolbar-top">
                {{-- Quick Stage Group Tabs --}}
                <div class="kanban-stage-tabs">
                    <button
                        type="button"
                        wire:click="$set('stageGroup', 'all')"
                        class="kanban-tab-btn {{ $this->stageGroup === 'all' ? 'active' : '' }}"
                    >
                        All 10 Stages
                    </button>
                    <button
                        type="button"
                        wire:click="$set('stageGroup', 'active')"
                        class="kanban-tab-btn {{ $this->stageGroup === 'active' ? 'active' : '' }}"
                    >
                        Active Pipeline
                    </button>
                    <button
                        type="button"
                        wire:click="$set('stageGroup', 'interviewing')"
                        class="kanban-tab-btn {{ $this->stageGroup === 'interviewing' ? 'active' : '' }}"
                    >
                        Interviews Only
                    </button>
                    <button
                        type="button"
                        wire:click="$set('stageGroup', 'closed')"
                        class="kanban-tab-btn {{ $this->stageGroup === 'closed' ? 'active' : '' }}"
                    >
                        Offers & Decisions
                    </button>
                </div>

                {{-- Scroll Navigation & New Button --}}
                <div class="kanban-scroll-nav">
                    <button
                        type="button"
                        x-on:click="scrollBoard(-320)"
                        class="kanban-nav-btn"
                        title="Scroll Left"
                    >
                        <x-filament::icon icon="heroicon-m-chevron-left" style="width: 18px; height: 18px;" />
                    </button>
                    <button
                        type="button"
                        x-on:click="scrollBoard(320)"
                        class="kanban-nav-btn"
                        title="Scroll Right"
                    >
                        <x-filament::icon icon="heroicon-m-chevron-right" style="width: 18px; height: 18px;" />
                    </button>
                    <a href="{{ route('filament.admin.resources.job-applications.create') }}" class="kanban-btn-create">
                        <x-filament::icon icon="heroicon-m-plus" style="width: 16px; height: 16px;" />
                        <span>New Application</span>
                    </a>
                </div>
            </div>

            <div class="kanban-filters-grid">
                <div class="kanban-filter-group">
                    <label>Search Role or Company</label>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Type to search..."
                        class="kanban-input"
                    />
                </div>
                <div class="kanban-filter-group">
                    <label>Filter by Company</label>
                    <select wire:model.live="selectedCompanyId" class="kanban-select">
                        <option value="">All Companies</option>
                        @foreach($this->companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="kanban-filter-group">
                    <label>Minimum Priority</label>
                    <select wire:model.live="minPriority" class="kanban-select">
                        <option value="">All Priorities</option>
                        <option value="5">★★★★★ (5 Stars)</option>
                        <option value="4">★★★★☆ (4+ Stars)</option>
                        <option value="3">★★★☆☆ (3+ Stars)</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Kanban Board Columns (Horizontally scrollable) --}}
        <div
            x-ref="boardContainer"
            class="kanban-board"
        >
            @foreach($this->columns as $statusKey => $column)
                <div
                    x-on:dragover="dragOver($event)"
                    x-on:drop="drop($event, '{{ $statusKey }}')"
                    class="kanban-column"
                >
                    {{-- Column Header --}}
                    <div class="kanban-column-header">
                        <span class="kanban-stage-pill stage-{{ $column['color'] }}">
                            {{ $column['label'] }}
                        </span>
                        <span class="kanban-count-pill">
                            {{ $column['items']->count() }}
                        </span>
                    </div>

                    {{-- Column Card List --}}
                    <div class="kanban-card-list">
                        @forelse($column['items'] as $app)
                            <div
                                draggable="true"
                                x-on:dragstart="dragStart($event, {{ $app->id }})"
                                class="kanban-card"
                            >
                                {{-- Company & Priority --}}
                                <div class="kanban-card-top">
                                    <div class="kanban-company-info">
                                        @if($app->company->logo_path)
                                            <img src="{{ Storage::url($app->company->logo_path) }}" alt="{{ $app->company->name }}" style="width: 20px; height: 20px; border-radius: 999px; object-fit: cover;" />
                                        @else
                                            <div class="kanban-company-avatar">
                                                {{ substr($app->company->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <span class="kanban-company-name">
                                            {{ $app->company->name }}
                                        </span>
                                    </div>
                                    <span class="kanban-priority-stars">
                                        {{ str_repeat('★', $app->priority_rating) }}
                                    </span>
                                </div>

                                {{-- Role Title Link --}}
                                <a
                                    href="{{ route('filament.admin.resources.job-applications.edit', ['record' => $app->id]) }}"
                                    class="kanban-job-title"
                                >
                                    {{ $app->job_title }}
                                </a>

                                {{-- Badges: Employment & Location --}}
                                <div class="kanban-tag-row">
                                    @if($app->employment_type)
                                        <span class="kanban-tag">
                                            {{ $app->employment_type->getLabel() }}
                                        </span>
                                    @endif
                                    @if($app->location_type)
                                        <span class="kanban-tag kanban-tag-blue">
                                            {{ $app->location_type->getLabel() }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Compensation --}}
                                @if($app->salary_offered)
                                    <div class="kanban-salary kanban-salary-offer">
                                        Offer: ${{ number_format((float) $app->salary_offered) }}
                                    </div>
                                @elseif($app->salary_min && $app->salary_max)
                                    <div class="kanban-salary">
                                        ${{ number_format((float) $app->salary_min) }} - ${{ number_format((float) $app->salary_max) }} / yr
                                    </div>
                                @endif

                                {{-- Upcoming Interview Round Banner --}}
                                @if($app->interviewRounds->isNotEmpty())
                                    @php $upcomingRound = $app->interviewRounds->first(); @endphp
                                    <div class="kanban-interview-alert">
                                        <div style="font-weight: 700; display: flex; align-items: center; gap: 4px;">
                                            <x-filament::icon icon="heroicon-m-calendar" style="width: 14px; height: 14px;" />
                                            <span>{{ $upcomingRound->round_type->getLabel() }}</span>
                                        </div>
                                        <div style="font-size: 11px; margin-top: 2px;">
                                            {{ $upcomingRound->scheduled_at?->format('M j, g:i A') }}
                                        </div>
                                    </div>
                                @endif

                                {{-- Card Footer & Move Stage Dropdown --}}
                                <div class="kanban-card-footer">
                                    <span>{{ $app->applied_date?->format('M j') ?? 'Saved' }}</span>

                                    {{-- Quick Move Dropdown --}}
                                    <select
                                        wire:change="updateApplicationStatus({{ $app->id }}, $event.target.value)"
                                        class="kanban-move-select"
                                    >
                                        <option value="" disabled selected>Move stage...</option>
                                        @foreach(\App\Enums\ApplicationStatus::cases() as $st)
                                            @if($st->value !== $app->status->value)
                                                <option value="{{ $st->value }}">{{ $st->getLabel() }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @empty
                            <div class="kanban-empty-col">
                                No applications
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
