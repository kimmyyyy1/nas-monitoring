<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OP No. 3 - Facilities Certified (Form & Dashboard)</title>
    
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f4f4; }
        
        /* SIDEBAR STYLE (Kahit naka-include, need pa rin ng CSS dito kung hindi global) */
        .sidebar { position: fixed; left: 0; top: 0; width: 260px; height: 100vh; background-color: #2c3e50; padding: 20px; box-sizing: border-box; color: white; overflow-y: auto; }
        .sidebar h3 { text-align: center; margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid #444; padding-bottom: 10px; }
        .sidebar a { display: block; color: #ecf0f1; text-decoration: none; padding: 15px; border-radius: 5px; margin-bottom: 10px; font-weight: bold; }
        .sidebar a:hover { background-color: #34495e; }
        .sidebar a.active { background-color: #007bff; color: white; }
        /* Submenu styles */
        .submenu a { padding-left: 30px !important; font-size: 0.9em; background-color: #233342; }

        /* MAIN CONTENT */
        .main-content { margin-left: 260px; padding: 20px; }
        h2 { color: #333; text-align: center; }
        .page-container { display: flex; gap: 20px; max-width: 100%; margin: auto; }
        
        /* COLUMNS */
        .form-column { flex: 2; min-width: 500px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 20px; }
        .graph-column { flex: 1; min-width: 400px; }
        
        /* STICKY */
        .sticky-wrapper { position: sticky; top: 20px; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        
        /* FORM ELEMENTS */
        form { padding: 0; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { margin-bottom: 5px; font-weight: bold; color: #555; }
        .form-group select, .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: Arial, sans-serif; }
        .span-2 { grid-column: 1 / -1; }
        
        /* ALERTS */
        .success-message { grid-column: 1 / -1; padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; }
        @if ($errors->any())
        .success-message { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
        @endif
        
        /* DASHBOARD ELEMENTS */
        .sticky-wrapper h3 { margin-top: 0; }
        .filters { background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .filters input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        
        /* TABLE STYLES */
        .table-container { max-height: 400px; overflow-y: auto; margin-top: 20px; }
        table.styled-table { border-collapse: collapse; width: 100%; font-size: 0.9em; }
        table.styled-table thead tr { background-color: #007bff; color: #ffffff; text-align: left; position: sticky; top: 0; }
        table.styled-table th, table.styled-table td { padding: 12px 15px; }
        table.styled-table tbody tr { border-bottom: 1px solid #ddd; }
        table.styled-table tbody tr:nth-of-type(even) { background-color: #f3f3f3; }
        table.styled-table tbody tr:last-of-type { border-bottom: 2px solid #007bff; }
        
        /* PAGINATION */
        .pagination { margin-top: 15px; }
        .pagination nav { display: flex; justify-content: space-between; }
        .pagination .hidden { display: none; }
        .pagination a, .pagination span { padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: #007bff; background: #fff; }
        .pagination .active span { background-color: #007bff; color: white; }
        .pagination .disabled span { color: #ccc; }
        
        /* BUTTON */
        .submit-button-sticky { width: 100%; padding: 12px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 20px; }
        .submit-button-sticky:hover { background-color: #218838; }
    </style>
</head>
<body>

    @include('reports.sidebar')

    <div class="main-content">

        <h2>OP No. 3: Facilities Certified (Entry & Monitoring)</h2>

        <form action="{{ route('reports.store-facility') }}" method="POST">
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
                            <label for="type_of_facility">Type of Facility: <span style="color:red;">*</span></label>
                            <input type="text" name="type_of_facility" id="type_of_facility" value="{{ old('type_of_facility') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="date_project_completed">Date Project Completed:</label>
                            <input type="date" name="date_project_completed" id="date_project_completed" value="{{ old('date_project_completed') }}">
                        </div>
                        <div class="form-group">
                            <label for="date_certified">Date Certified: <span style="color:red;">*</span></label>
                            <input type="date" name="date_certified" id="date_certified" value="{{ old('date_certified') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="certifying_body">Certifying Body:</label>
                            <input type="text" name="certifying_body" id="certifying_body" value="{{ old('certifying_body') }}">
                        </div>
                        <div class="form-group">
                            <label for="movs">MOVs (Means of Verification):</label>
                            <input type="text" name="movs" id="movs" value="{{ old('movs') }}">
                        </div>

                    </div>
                </div>

                <div class="graph-column">
                    <div class="sticky-wrapper">
                        <h3>Certified Facilities</h3>
                        
                        <div class="filters">
                            <label for="search_filter" style="font-weight: bold;">Search Facilities:</label>
                            <input type="text" id="search_filter" placeholder="Type facility or body..." onchange="applyFilters()" value="{{ $search ?? '' }}">
                        </div>

                        <div class="table-container">
                            <table class="styled-table">
                                <thead>
                                    <tr>
                                        <th>Type of Facility</th>
                                        <th>Date Certified</th>
                                        <th>Certifying Body</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($facilities as $facility)
                                    <tr>
                                        <td>{{ $facility->type_of_facility }}</td>
                                        <td>{{ \Carbon\Carbon::parse($facility->date_certified)->format('M d, Y') }}</td>
                                        <td>{{ $facility->certifying_body }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" style="text-align: center;">No facilities found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="pagination">
                            {{ $facilities->appends(['search' => $search ?? ''])->links() }}
                        </div>
                        
                        <button type="submit" class="submit-button-sticky">Save New Facility Report</button>
                        
                        <script>
                            function applyFilters() {
                                let search = document.getElementById('search_filter').value;
                                let url = `{{ route('reports.create-facility') }}?search=${encodeURIComponent(search)}`;
                                window.location.href = url;
                            }
                        </script>
                    </div> 
                </div> 
            </div> 
        </form>

    </div> </body>
</html>