        // ESTADO DE LOS DATOS DE LA APLICACIÓN (MOCK DATA COMPLETO)
        let datosDespachos = [
            { id: "DESP-101", cliente: "Sernapesca Distribución", patente: "TSA-010", destino: "Punta Arenas", estado: "En tránsito", temp: -18.4, tipo: "Frigorífico" },
            { id: "DESP-102", cliente: "Agro商 Austral", patente: "TSA-042", destino: "Coyhaique", estado: "En tránsito", temp: -18.1, tipo: "Frigorífico" },
            { id: "DESP-103", cliente: "Logística Central SA", patente: "TSA-088", destino: "Puerto Montt", estado: "Entregado", temp: null, tipo: "Carga Seca" },
            { id: "DESP-104", cliente: "Supermercados del Sur", patente: "TSA-112", destino: "Punta Arenas", estado: "En tránsito", temp: -19.0, tipo: "Frigorífico" }
        ];

        // Cambiar entre pestañas de manera instantánea
        function switchTab(tabId) {
            document.querySelectorAll('.content-body').forEach(section => {
                section.classList.remove('active-tab');
            });
            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('active');
            });

            document.getElementById(`tab-${tabId}`).classList.add('active-tab');
            
            // Buscar el elemento del menú cliqueado para dejarlo activo visualmente
            const activeMenu = Array.from(document.querySelectorAll('.menu-item')).find(item => item.textContent.toLowerCase().includes(tabId === 'iot' ? 'sensores' : tabId));
            if(activeMenu) activeMenu.classList.add('active');
        }

        // Renderizador Central de Tablas
        function actualizarTablas() {
            // 1. Contador KPI
            const enTransito = datosDespachos.filter(d => d.estado === "En tránsito").length;
            document.getElementById('kpi-transit').textContent = enTransito;

            // 2. Tabla Resumen del Dashboard
            const tbodyDash = document.querySelector('#table-dashboard-summary tbody');
            tbodyDash.innerHTML = '';
            datosDespachos.forEach(d => {
                let badgeClass = d.estado === 'En tránsito' ? 'badge-warning' : 'badge-success';
                let tempDisplay = d.tipo === 'Carga Seca' ? 'N/A (Seco)' : `${d.temp.toFixed(1)} °C`;
                let tempStyle = d.temp > -15 ? 'color: var(--danger); font-weight:bold;' : (d.temp > -18 ? 'color: var(--warning);' : 'color: var(--success);');

                tbodyDash.innerHTML += `
                    <tr>
                        <td><strong>${d.patente}</strong></td>
                        <td>Santiago ➔ ${d.destino}</td>
                        <td style="${tempStyle}">${tempDisplay}</td>
                        <td><span class="badge ${badgeClass}">${d.estado}</span></td>
                    </tr>
                `;
            });

            // 3. Tabla Completa de Despachos
            const tbodyDesp = document.querySelector('#table-despachos-full tbody');
            tbodyDesp.innerHTML = '';
            datosDespachos.forEach(d => {
                let badgeClass = d.estado === 'En tránsito' ? 'badge-warning' : 'badge-success';
                tbodyDesp.innerHTML += `
                    <tr>
                        <td>${d.id}</td>
                        <td>${d.cliente}</td>
                        <td><span style="font-family: monospace;">${d.patente}</span></td>
                        <td>${d.destino}</td>
                        <td><span class="badge ${badgeClass}">${d.estado}</span></td>
                    </tr>
                `;
            });

            // 4. Tabla de Módulo IoT
            const tbodyIot = document.querySelector('#table-iot-telemetry tbody');
            tbodyIot.innerHTML = '';
            datosDespachos.filter(d => d.tipo === "Frigorífico").forEach(d => {
                let statusSensor = d.temp > -15 ? '<span class="badge badge-danger">Falla de Frío</span>' : '<span class="badge badge-success">Estable</span>';
                tbodyIot.innerHTML += `
                    <tr>
                        <td><strong>${d.patente}</strong></td>
                        <td style="font-weight: bold; font-family: monospace;">${d.temp.toFixed(1)} °C</td>
                        <td>${statusSensor}</td>
                        <td>
                            <button class="btn btn-primary" onclick="ajustarTermostato('${d.patente}')" style="padding:2px 8px; font-size:0.75rem;">
                                <i class="fa-solid fa-sliders"></i> Ajustar
                            </button>
                        </td>
                    </tr>
                `;
            });
        }

        // Lógica: Crear Nuevo Despacho dinámicamente
        function crearDespacho(e) {
            e.preventDefault();
            const cliente = document.getElementById('form-cliente').value;
            const patente = document.getElementById('form-patente').value;
            const destino = document.getElementById('form-destino').value;
            const nuevoId = `DESP-${100 + datosDespachos.length + 1}`;

            datosDespachos.push({
                id: nuevoId,
                cliente: cliente,
                patente: patente.toUpperCase(),
                destino: destino,
                estado: "En tránsito",
                temp: -18.5, // Inicializa óptimo si es frigorífico simulado
                tipo: "Frigorífico"
            });

            // Limpiar formulario y refrescar interfaz
            document.getElementById('form-despacho').reset();
            actualizarTablas();
            
            // Log en consola IA
            const consola = document.getElementById('ia-console');
            consola.innerHTML += `<br>[SISTEMA] Nuevo despacho ${nuevoId} registrado. IA calculando ventana horaria óptima para el tramo austral...`;
        }

        // Simulación de interacción: Forzar Alerta Crítica IoT (Para demostración frente a evaluadores)
        function triggerFallaIotSimulada() {
            const camionCritico = datosDespachos.find(d => d.patente === "TSA-042");
            if (camionCritico) {
                camionCritico.temp = -12.4; // Sube peligrosamente rompiendo el rango de -18°C
                document.getElementById('alert-truck-id').textContent = camionCritico.patente;
                document.getElementById('global-alert-banner').classList.add('visible');
                actualizarTablas();

                // Alerta en la consola de IA
                const consola = document.getElementById('ia-console');
                consola.innerHTML += `<br><span style="color:var(--danger)">[CRÍTICO] Alerta IoT en unidad ${camionCritico.patente}. Temperatura actual: -12.4°C. Riesgo inminente de pérdida de producto.</span>`;
                consola.scrollTop = consola.scrollHeight;
            }
        }

        // Acción de Mitigación Remota IoT
        function mitigarAlerta() {
            const camionCritico = datosDespachos.find(d => d.patente === "TSA-042");
            if (camionCritico) {
                camionCritico.temp = -18.2; // Vuelve a su estado óptimo
                document.getElementById('global-alert-banner').classList.remove('visible');
                actualizarTablas();

                const consola = document.getElementById('ia-console');
                consola.innerHTML += `<br><span style="color:var(--success)">[SISTEMA] Comando remoto ejecutado con éxito. Compresor de la unidad ${camionCritico.patente} reconfigurado a -18.2°C.</span>`;
                consola.scrollTop = consola.scrollHeight;
            }
        }

        function ajustarTermostato(patente) {
            const camion = datosDespachos.find(d => d.patente === patente);
            if (camion) {
                camion.temp = -19.1;
                alert(`Termostato de unidad IoT ${patente} forzado remotamente a -19.1°C de forma preventiva.`);
                actualizarTablas();
            }
        }

        // Lógica del Módulo de Inteligencia Artificial Predictiva
        function activarContingenciaClimatica(tipo) {
            const consola = document.getElementById('ia-console');
            if (tipo === 'Nieve Extrema') {
                consola.innerHTML += `<br><span style="color:var(--warning)">[IA - CLIMA] API OpenWeather reporta tormenta de nieve severa en Paso Monte Aymond (Acceso a Punta Arenas).</span>`;
                consola.innerHTML += `<br>[IA - ACCIÓN] Re-enrutando camiones en tránsito a través de la ruta alternativa sugerida por modelo predictivo. Desvío automatizado enviado por SMS/App a conductores. Evitado retraso proyectado de 5.5 horas.`;
            } else {
                consola.innerHTML += `<br>[IA] Condiciones de ruta restablecidas. Despejado en todo el corredor Santiago - Punta Arenas.`;
            }
            consola.scrollTop = consola.scrollHeight;
        }

        // Inicialización automática de la aplicación al cargar
        window.onload = function() {
            actualizarTablas();

            // Simulación ligera: Variación milimétrica constante de temperatura para dar sensación de "Tiempo Real"
            setInterval(() => {
                datosDespachos.forEach(d => {
                    if (d.tipo === "Frigorífico" && d.patente !== "TSA-042") {
                        // Fluctúa levemente la temperatura de los camiones estables
                        d.temp += (Math.random() - 0.5) * 0.2;
                    }
                });
                actualizarTablas();
            }, 8000);
        };