<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Physical Targets</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f4f4; }
        
        /* Simple Centered Layout para sa Edit Form */
        .container { 
            max-width: 900px; 
            margin: 50px auto; 
            background: white; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: center; }
        th { background-color: #007bff; color: white; }
        td:first-child { text-align: left; font-weight: bold; color: #555; }
        
        /* Input Styles */
        input[type="number"] { 
            width: 80px; 
            padding: 8px; 
            text-align: center; 
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        input[type="number"]:focus { border-color: #007bff; outline: none; }

        /* Buttons */
        .btn-container { text-align: right; margin-top: 30px; }
        
        .btn-save { 
            background-color: #28a745; 
            color: white; 
            padding: 12px 25px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: bold;
        }
        .btn-save:hover { background-color: #218838; }

        .btn-cancel { 
            background-color: #6c757d; 
            color: white; 
            padding: 12px 25px; 
            border: none; 
            border-radius: 4px; 
            text-decoration: none; 
            margin-left: 10px;
            font-size: 16px;
        }
        .btn-cancel:hover { background-color: #5a6268; }
    </style>
</head>
<body>

    <div class="container">
        <h2>✏️ Edit Physical Targets (Budget Year)</h2>
        <p style="text-align: center; color: #666; margin-bottom: 20px;">
            Ilagay dito ang target na bilang para sa bawat quarter.
        </p>
        
        <form action="{{ route('reports.update-targets') }}" method="POST">
            @csrf
            
            <table>
                <thead>
                    <tr>
                        <th style="width: 40%;">Indicator / Program</th>
                        <th>Q1 Target</th>
                        <th>Q2 Target</th>
                        <th>Q3 Target</th>
                        <th>Q4 Target</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($targets as $target)
                    <tr>
                        <td>{{ $target->indicator_name }}</td>
                        
                        <td><input type="number" name="targets[{{ $target->id }}][q1]" value="{{ $target->q1_target }}" min="0"></td>
                        <td><input type="number" name="targets[{{ $target->id }}][q2]" value="{{ $target->q2_target }}" min="0"></td>
                        <td><input type="number" name="targets[{{ $target->id }}][q3]" value="{{ $target->q3_target }}" min="0"></td>
                        <td><input type="number" name="targets[{{ $target->id }}][q4]" value="{{ $target->q4_target }}" min="0"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="btn-container">
                <button type="submit" class="btn-save">Save Changes</button>
                <a href="{{ route('reports.bar-report') }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>