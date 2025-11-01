<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Atenciones por Enfermedad/Motivo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        thead {
            background-color: #FF5722;
            color: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-row {
            background-color: #ffe8e0 !important;
            font-weight: bold;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 3px;
            font-weight: bold;
        }
        .badge-danger {
            background-color: #f44336;
            color: white;
        }
        .badge-success {
            background-color: #4CAF50;
            color: white;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE ATENCIONES POR ENFERMEDAD/MOTIVO</h1>
        <p>Sistema de Gestión y Registro de Atenciones Médicas - SIGRAM</p>
        <p>La Salle Urubamba</p>
        <p><strong>Fecha de generación:</strong> {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Enfermedad / Motivo de Consulta</th>
                <th style="text-align: center;">Total de Atenciones</th>
                <th style="text-align: center;">Porcentaje</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalGeneral = $enfermedades->sum();
            @endphp
            @forelse($enfermedades as $enfermedad => $total)
                <tr>
                    <td><strong>{{ $enfermedad }}</strong></td>
                    <td style="text-align: center;">
                        <span class="badge badge-danger">{{ $total }}</span>
                    </td>
                    <td style="text-align: center;">
                        {{ $totalGeneral > 0 ? number_format(($total / $totalGeneral) * 100, 1) : 0 }}%
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">No hay datos disponibles</td>
                </tr>
            @endforelse
            @if($totalGeneral > 0)
                <tr class="total-row">
                    <td><strong>TOTAL</strong></td>
                    <td style="text-align: center;">
                        <span class="badge badge-success">{{ $totalGeneral }}</span>
                    </td>
                    <td style="text-align: center;">100%</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>Este reporte fue generado automáticamente por el Sistema SIGRAM</p>
        <p>© {{ date('Y') }} La Salle Urubamba - Tópico Médico</p>
    </div>
</body>
</html>
