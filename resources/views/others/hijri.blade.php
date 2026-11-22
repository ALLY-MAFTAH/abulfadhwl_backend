@extends('layouts.app')

@section('content')
    @php($names = \App\Models\HijriMonth::NAMES)
    <div class="py-3">
        <div class="container">
            @if (Session::has('success'))
                <p class="alert alert-success">{{ Session::get('success') }}</p>
            @endif
            @if ($errors->any())
                <p class="alert alert-danger">{{ $errors->first() }}</p>
            @endif

            <div class="card bg-white mb-3">
                <div class="card-header"><h4>KALENDA YA HIJRI: Mwanzo wa mwezi (kwa kuonekana mwezi)</h4></div>
                <div class="card-body">
                    <p class="mb-3" style="line-height:1.7">
                        Mwezi ukishaonekana (au idadi ya siku 30 kukamilika), ingiza hapa tarehe ya kawaida
                        (Gregorian) ya <b>siku ya kwanza</b> ya mwezi huo wa Hijri. Programu itatumia tarehe hii
                        badala ya hesabu. Miezi ambayo haijaingizwa inaonyeshwa kama <b>makadirio</b>.
                    </p>
                    <form method="POST" action="{{ route('add_hijri') }}" class="form-row align-items-end">
                        @csrf
                        <div class="col-md-3 mb-2">
                            <label>Mwezi wa Hijri</label>
                            <select name="hijri_month" class="form-control" required>
                                @foreach ($names as $n => $label)
                                    <option value="{{ $n }}" @selected(old('hijri_month') == $n)>{{ $n }}. {{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label>Mwaka (H)</label>
                            <input type="number" name="hijri_year" class="form-control" min="1440" max="1500"
                                value="{{ old('hijri_year') }}" placeholder="1448" required>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Siku ya 1 (tarehe ya kawaida)</label>
                            <input type="date" name="starts_on" class="form-control" value="{{ old('starts_on') }}" required>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Maelezo (si lazima)</label>
                            <input type="text" name="note" class="form-control" maxlength="160"
                                value="{{ old('note') }}" placeholder="mf. Mwezi umeonekana Tanga">
                        </div>
                        <div class="col-md-1 mb-2">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card bg-white">
                <div class="card-header"><h4>Miezi iliyothibitishwa ({{ $months->count() }})</h4></div>
                <table class="table table-striped table-responsive-lg mb-0">
                    <thead class="thead-dark">
                        <tr><th>Mwezi</th><th>Mwaka</th><th>Ulianza (siku ya 1)</th><th>Maelezo</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse ($months as $m)
                            <tr>
                                <td>{{ $m->hijri_month }}. {{ $names[$m->hijri_month] ?? '' }}</td>
                                <td>{{ $m->hijri_year }}H</td>
                                <td>{{ $m->starts_on->format('D, d M Y') }}</td>
                                <td>{{ $m->note }}</td>
                                <td>
                                    <form method="POST" action="{{ route('delete_hijri', $m->id) }}"
                                        onsubmit="return confirm('Kufuta mwezi huu?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Bado hakuna mwezi uliothibitishwa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
