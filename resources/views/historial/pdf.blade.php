<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Clínico - {{ $paciente->dni }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #1e3c72;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #1e3c72;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header h2 {
            color: #666;
            font-size: 16px;
            font-weight: normal;
        }

        .info-paciente {
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-paciente h3 {
            color: #1e3c72;
            font-size: 14px;
            margin-bottom: 10px;
            border-bottom: 2px solid #1e3c72;
            padding-bottom: 5px;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .info-col {
            display: table-cell;
            width: 25%;
            vertical-align: top;
        }

        .info-col strong {
            display: block;
            color: #1e3c72;
            font-size: 10px;
            margin-bottom: 3px;
        }

        .info-col span {
            display: block;
            font-size: 12px;
            color: #333;
        }

        .resumen {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .resumen-item {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            background: #f9f9f9;
        }

        .resumen-item .numero {
            font-size: 28px;
            font-weight: bold;
            color: #4CAF50;
            display: block;
        }

        .resumen-item .texto {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }

        .historial-title {
            color: #1e3c72;
            font-size: 16px;
            margin: 20px 0 10px 0;
            border-bottom: 2px solid #1e3c72;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead {
            background: #1e3c72;
            color: white;
        }

        table th {
            padding: 8px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
        }

        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }

        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        .medicamentos-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .medicamentos-list li {
            font-size: 9px;
            margin-bottom: 3px;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #ddd;
            text-align: center;
            font-size: 9px;
            color: #666;
        }

        .footer strong {
            display: block;
            font-size: 11px;
            color: #1e3c72;
            margin-bottom: 5px;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            background: #f9f9f9;
            border: 1px dashed #ccc;
            color: #666;
        }

        /* Evitar saltos de página dentro de elementos */
        .info-paciente, .resumen, table {
            page-break-inside: avoid;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <!-- ENCABEZADO -->
    <div class="header">
        <h1>HISTORIAL CLÍNICO DEL PACIENTE</h1>
        <h2>Tópico La Salle Urubamba</h2>
    </div>

    <!-- INFORMACIÓN DEL PACIENTE -->
    <div class="info-paciente">
        <h3>INFORMACIÓN DEL PACIENTE</h3>
        <div class="info-row">
            <div class="info-col">
                <strong>DNI:</strong>
                <span>{{ $paciente->dni }}</span>
            </div>
            <div class="info-col">
                <strong>NOMBRE COMPLETO:</strong>
                <span>{{ $paciente->nombre }} {{ $paciente->apellido }}</span>
            </div>
            <div class="info-col">
                <strong>EDAD:</strong>
                <span>{{ $paciente->edad }} años</span>
            </div>
            <div class="info-col">
                <strong>CARRERA/ÁREA:</strong>
                <span>
                    @if($paciente->carrera)
                        {{ $paciente->carrera->nombre }} ({{ $paciente->carrera->acronimo }})
                    @else
                        {{ $paciente->otros_especificacion ?? 'No especificado' }}
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- RESUMEN DE ATENCIONES -->
    <div class="resumen">
        <div class="resumen-item">
            <span class="numero">{{ $paciente->atenciones->count() }}</span>
            <span class="texto">Total de Atenciones</span>
        </div>
        <div class="resumen-item">
            <span class="numero">{{ $paciente->atenciones->where('created_at', '>=', now()->subDays(30))->count() }}</span>
            <span class="texto">Últimos 30 días</span>
        </div>
        <div class="resumen-item">
            <span class="numero">{{ $paciente->atenciones->first() ? $paciente->atenciones->first()->created_at->format('d/m/Y') : 'N/A' }}</span>
            <span class="texto">Primera Atención</span>
        </div>
    </div>

    <!-- HISTORIAL DE ATENCIONES -->
    <h3 class="historial-title">HISTORIAL DE ATENCIONES</h3>

    @if($paciente->atenciones->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 12%;">FECHA</th>
                    <th style="width: 10%;">H. ENTRADA</th>
                    <th style="width: 10%;">H. SALIDA</th>
                    <th style="width: 18%;">MOTIVO</th>
                    <th style="width: 25%;">MEDICAMENTOS</th>
                    <th style="width: 20%;">OBSERVACIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paciente->atenciones->sortByDesc('created_at') as $index => $atencion)
                    <tr>
                        <td><strong>{{ $index + 1 }}</strong></td>
                        <td>{{ $atencion->fecha ? \Carbon\Carbon::parse($atencion->fecha)->format('d/m/Y') : $atencion->created_at->format('d/m/Y') }}</td>
                        <td>{{ $atencion->hora_entrada }}</td>
                        <td>
                            @if($atencion->hora_salida)
                                {{ $atencion->hora_salida }}
                            @else
                                <span class="badge badge-warning">En atención</span>
                            @endif
                        </td>
                        <td>
                            @if($atencion->motivo)
                                <span class="badge badge-info">{{ $atencion->motivo->nombre }}</span>
                            @else
                                {{ $atencion->motivo_otro }}
                            @endif
                        </td>
                        <td>
                            @if($atencion->medicamentos->count() > 0)
                                <ul class="medicamentos-list">
                                    @foreach($atencion->medicamentos as $med)
                                        <li>
                                            • {{ $med->nombre }}
                                            @if($med->pivot->cantidad_usada)
                                                ({{ $med->pivot->cantidad_usada }} und.)
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $atencion->observaciones ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            Este paciente no tiene atenciones registradas.
        </div>
    @endif

    <!-- PIE DE PÁGINA -->
    <div class="footer">
        <strong>Tópico La Salle Urubamba</strong>
        <p>Historial Clínico generado el {{ now()->format('d/m/Y H:i') }}</p>
        <p>Este documento es confidencial y solo debe ser utilizado para fines médicos.</p>
    </div>
</body>
</html>
