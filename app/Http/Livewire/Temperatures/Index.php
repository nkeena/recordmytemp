<?php

namespace App\Http\Livewire\Temperatures;

use App\Temperature;
use Livewire\Component;
use JamesMills\LaravelTimezone\Facades\Timezone;

class Index extends Component
{
    public $filter = 'today';
    public $startDate;
    public $endDate;
    public $dateFilterSelected;
    public $timestampFormat;
    public $search = '';

    protected $updatesQueryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => ''],
    ];

    protected $listeners = ['deleteTemperature'];

    public function mount()
    {
        $this->filter = request()->query('filter', $this->filter);
        $this->updatedFilter();

        $this->search = request()->query('search', $this->search);
    }

    public function deleteTemperature($id)
    {
        $temp = Temperature::findOrFail($id);

        $temp->delete();
    }

    public function updatedFilter()
    {
        if ($this->filter == 'today') {
            $this->dateFilterSelected = Timezone::convertToLocal(now(), 'M d, Y');
            $this->timestampFormat = 'h:i a';
        }

        if ($this->filter == 'yesterday') {
            $this->dateFilterSelected = Timezone::convertToLocal(now()->subDay(), 'M d, Y');
            $this->timestampFormat = 'h:i a';
        }

        if ($this->filter == 'week') {
            $this->dateFilterSelected = now()->startOfWeek()->format('M d') . ' - ' . now()->endOfWeek()->format('M d, Y');
            $this->timestampFormat = 'D h:i a';
        }

        if ($this->filter == 'month') {
            $this->dateFilterSelected = now()->startOfMonth()->format('M d') . ' - ' . now()->endOfMonth()->format('M d, Y');
            $this->timestampFormat = 'M d, h:i a';
        }
    }

    public function render()
    {
        return view('livewire.temperatures.index', [
            'temperatures' => $this->fetchTemperatures()
        ]);
    }

    public function fetchTemperatures()
    {
        $query = auth()->user()->is_owner ? Temperature::query() : auth()->user()->temperatures();

        return $query
            ->where('log_id', auth()->user()->currentLog->id)
            ->when($this->search, fn ($q) => $q->search($this->search))
            ->when($this->filter === 'today', fn ($q) => $q->today())
            ->when($this->filter === 'yesterday', fn ($q) => $q->yesterday())
            ->when($this->filter === 'week', fn ($q) => $q->thisWeek())
            ->when($this->filter === 'month', fn ($q) => $q->thisMonth())
            ->when($this->filter === 'custom' && $this->startDate && $this->endDate, fn ($q) => $q->dateRange($this->startDate, $this->endDate))
            ->latest()
            ->get();
    }
}
