<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Medicamentos con Stock Bajo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
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
        .alert {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }
        .alert strong {
            color: #856404;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        thead {
            background-color: #ff9800;
            color: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 10px;
        }
        .badge-warning {
            background-color: #ff9800;
            color: white;
        }
        .badge-danger {
            background-color: #f44336;
            color: white;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .vencido {
            background-color: #ffebee !important;
        }
        .proximo-vencer {
            background-color: #fff3e0 !important;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE MEDICAMENTOS CON STOCK BAJO</h1>
        <p>Sistema de Gestión y Registro de Atenciones Médicas - SIGRAM</p>
        <p>La Salle Urubamba</p>
        <p><strong>Fecha de generación:</strong> {{ date('d/m/Y H:i:s') }}</p>
    </div>

    @if($medicamentos->count() > 0)
        <div class="alert">
            <strong>⚠️ ALERTA:</strong> Se encontraron {{ $medicamentos->count() }} medicamento(s) con stock por debajo del mínimo establecido.
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Medicamento</th>
                <th style="text-align: center;">Stock Actual</th>
                <th style="text-align: center;">Stock Mínimo</th>
                <th style="text-align: center;">Diferencia</th>
                <th style="text-align: center;">Fecha Vencimiento</th>
                <th style="text-align: center;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($medicamentos as $medicamento)
                @php
                    $diasParaVencer = null;
                    $claseVencimiento = '';
                    if ($medicamento->fecha_vencimiento) {
                        $diasParaVencer = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($medicamento->fecha_vencimiento), false);
                        if ($diasParaVencer < 0) {
                            $claseVencimiento = 'vencido';
                        } elseif ($diasParaVencer <= 30) {
                            $claseVencimiento = 'proximo-vencer';
                        }
                    }
                    $diferencia = $medicamento->cantidad_stock - $medicamento->stock_minimo_alerta;
                @endphp
                <tr class="{{ $claseVencimiento }}">
                    <td><strong>{{ $medicamento->nombre }}</strong></td>
                    <td class="text-center">
                        <span class="badge badge-danger">{{ $medicamento->cantidad_stock }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-warning">{{ $medicamento->stock_minimo_alerta }}</span>
                    </td>
                    <td class="text-center">
                        <strong style="color: #f44336;">{{ $diferencia }}</strong>
                    </td>
                    <td class="text-center">
                        @if($medicamento->fecha_vencimiento)
                            {{ \Carbon\Carbon::parse($medicamento->fecha_vencimiento)->format('d/m/Y') }}
                            @if($diasParaVencer !== null)
                                <br>
                                <small style="color: #666;">
                                    @if($diasParaVencer < 0)
                                        (Vencido hace {{ abs($diasParaVencer) }} días)
                                    @elseif($diasParaVencer == 0)
                                        (Vence hoy)
                                    @else
                                        ({{ $diasParaVencer }} días)
                                    @endif
                                </small>
                            @endif
                        @else
                            <span style="color: #999;">N/A</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($medicamento->cantidad_stock == 0)
                            <span class="badge badge-danger">SIN STOCK</span>
                        @else
                            <span class="badge badge-warning">STOCK BAJO</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        ✅ No hay medicamentos con stock bajo. ¡Todo en orden!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($medicamentos->count() > 0)
        <div style="margin-top: 20px; padding: 15px; background-color: #f5f5f5; border-radius: 4px;">
            <h3 style="margin-top: 0; color: #333;">Recomendaciones:</h3>
            <ul style="margin: 0; padding-left: 20px; color: #666;">
                <li>Realizar pedido urgente de los medicamentos marcados como "SIN STOCK"</li>
                <li>Planificar reabastecimiento de medicamentos con stock bajo</li>
                <li>Revisar y retirar medicamentos vencidos</li>
                <li>Contactar al proveedor para medicamentos próximos a vencer</li>
            </ul>
        </div>
    @endif

    <div class="footer">
        <p>Este reporte fue generado automáticamente por el Sistema SIGRAM</p>
        <p>© {{ date('Y') }} La Salle Urubamba - Tópico Médico</p>
    </div>
</body>
</html>
