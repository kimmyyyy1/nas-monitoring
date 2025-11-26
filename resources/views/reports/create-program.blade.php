<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OP No. 1 - Programs Implemented (Form & Dashboard)</title>
    <style>
        /* --- STYLES PARA SA SIDEBAR LAYOUT --- */
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            background-color: #f4f4f4; 
        }
        .sidebar {
            position: fixed; left: 0; top: 0; width: 260px; height: 100vh;
            background-color: #2c3e50; padding: 20px; box-sizing: border-box;
            color: white; overflow-y: auto;
        }
        .sidebar h3 { text-align: center; margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid #444; padding-bottom: 10px; }
        .sidebar a { display: block; color: #ecf0f1; text-decoration: none; padding: 15px; border-radius: 5px; margin-bottom: 10px; font-weight: bold; }
        .sidebar a:hover { background-color: #34495e; }
        .sidebar a.active { background-color: #007bff; color: white; }
        .main-content { margin-left: 260px; padding: 20px; }
        /* ----------------------------------------------- */

        h2 { color: #333; text-align: center; }
        .page-container { display: flex; gap: 20px; max-width: 100%; margin: auto; }
        .form-column { flex: 2; min-width: 500px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 20px; }
        .graph-column { flex: 1; min-width: 400px; }
        .sticky-wrapper { position: sticky; top: 20px; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        form { padding: 0; }
        /* Ang form na ito ay 2-column grid */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { margin-bottom: 5px; font-weight: bold; color: #555; }
        .form-group select, .form-group input, .form-group textarea { 
            width: 100%; padding: 10px; border: 1px solid #ccc; 
            border-radius: 4px; box-sizing: border-box; font-family: Arial, sans-serif; 
        }
        .form-group textarea { min-height: 120px; resize: vertical; }
        .span-2 { grid-column: 1 / -1; } /* Para sa 2-column span */
        .success-message { grid-column: 1 / -1; padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; }
        @if ($errors->any())
        .success-message { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
        @endif
        .sticky-wrapper h3 { margin-top: 0; }
        .filters { background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .filters input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }

        /* --- BAGONG STYLES PARA SA TABLE --- */
        .table-container { max-height: 400px; overflow-y: auto; margin-top: 20px; }
        table.styled-table { border-collapse: collapse; width: 100%; font-size: 0.9em; }
        table.styled-table thead tr { background-color: #007bff; color: #ffffff; text-align: left; }
        table.styled-table th, table.styled-table td { padding: 12px 15px; }
        table.styled-table tbody tr { border-bottom: 1px solid #ddd; }
        table.styled-table tbody tr:nth-of-type(even) { background-color: #f3f3f3; }
        table.styled-table tbody tr:last-of-type { border-bottom: 2px solid #007bff; }
        .pagination { margin-top: 15px; }
        .pagination svg { width: 18px; height: 18px; }
        /* --------------------------------- */

        .submit-button-sticky { width: 100%; padding: 12px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 20px; }
        .submit-button-sticky:hover { background-color: #218838; }
    </style>
</head>
<body>

    <div class="sidebar">
    <h3>NAS M&E System</h3>
    
    <a href="{{ route('main.dashboard') }}" class="{{ request()->routeIs('main.dashboard') ? 'active' : '' }}">Main Dashboard</a> 
    <hr style="border-color: #444;">
    
    <a href="{{ route('reports.create') }}" class="{{ request()->routeIs('reports.create') ? 'active' : '' }}">OC-1: Learning Standards</a>
    <a href="{{ route('reports.create-retention') }}" class="{{ request()->routeIs('reports.create-retention') ? 'active' : '' }}">OC-2: Retention Rate</a>
    <a href="{{ route('reports.create-medals') }}" class="{{ request()->routeIs('reports.create-medals') ? 'active' : '' }}">OC-3: Medal Tally</a>
    
    <a href="{{ route('reports.create-athletes-trained') }}" class="{{ request()->routeIs('reports.create-athletes-trained') ? 'active' : '' }}">OP-2: Athletes Trained</a>
    <a href="{{ route('reports.create-program') }}" class="{{ request()->routeIs('reports.create-program') ? 'active' : '' }}">OP-1: Programs</a>
    <a href="{{ route('reports.create-facility') }}" class="{{ request()->routeIs('reports.create-facility') ? 'active' : '' }}">OP-3: Facilities</a>
    
    <hr style="border-color: #444;">
    <a href="{{ route('reports.bar-report') }}" class="{{ request()->routeIs('reports.bar-report') ? 'active' : '' }}" style="color: #ffd700;">BAR No. 1 Report</a>
</div>

    <div class="main-content">

        <h2>OP No. 1: Programs Implemented (Entry & Monitoring)</h2>

        <form action="{{ route('reports.store-program') }}" method="POST">
            @csrf

            <div class="page-container">

                <div class="form-column">
                    <div class="form-grid">

                        @if (session('success'))
                            <div class="success-message">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="success-message">
                                <strong>Error!</strong> May mga problema sa iyong input:
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group span-2">
                            <label for="program_title">Program Title: <span style="color:red;">*</span></label>
                            <input type="text" name="program_title" id="program_title" value="{{ old('program_title') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="proponent">Proponent:</label>
                            <input type="text" name="proponent" id="proponent" value="{{ old('proponent') }}">
                        </div>
                        <div class="form-group">
                            <label for="target_beneficiaries">Target Beneficiaries:</label>
                            <input type="text" name="target_beneficiaries" id="target_beneficiaries" value="{{ old('target_beneficiaries') }}">
                        </div>

                        <div class="form-group span-2">
                            <label for="output_indicator">Output Indicator:</label>
                            <input type="text" name="output_indicator" id="output_indicator" value="{{ old('output_indicator') }}">
                        </div>

                        <div class="form-group span-2">
                            <label for="accomplishment">Accomplishment / Description:</label>
                            <textarea name="accomplishment" id="accomplishment">{{ old('accomplishment') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="date_of_implementation">Date of Implementation: <span style="color:red;">*</span></label>
                            <input type="date" name="date_of_implementation" id="date_of_implementation" value="{{ old('date_of_implementation') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="date_of_completion">Date of Completion:</label>
                            <input type="date" name="date_of_completion" id="date_of_completion" value="{{ old('date_of_completion') }}">
                        </div>

                        <div class="form-group span-2">
                            <label for="movs">MOVs (Means of Verification):</label>
                            <input type="text" name="movs" id="movs" value="{{ old('movs') }}">
                        </div>

                    </div>
                </div>

                <div class="graph-column">
                    <div class="sticky-wrapper">
                        <h3>Submitted Programs</h3>

                        <div class="filters">
                            <form action="{{ route('reports.create-program') }}" method="GET">
                                <input type="text" name="search" placeholder="Search by Title, Proponent..." value="{{ $search ?? '' }}">
                            </form>
                        </div>

                        <div class="table-container">
                            <table class="styled-table">
                                <thead>
                                    <tr>
                                        <th>Program Title</th>
                                        <th>Date Implemented</th>
                                        <th>Proponent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($programs as $program)
                                    <tr>
                                        <td>{{ $program->program_title }}</td>
                                        <td>{{ $program->date_of_implementation }}</td>
                                        <td>{{ $program->proponent }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" style="text-align: center;">No programs found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="pagination">
                            {{ $programs->appends(['search' => $search ?? ''])->links() }}
                        </div>

                        <button type="submit" class="submit-button-sticky">Save New Program</button>
                    </div> 
                </div> 
            </div> 
        </form>

    </div> </body>
</html>