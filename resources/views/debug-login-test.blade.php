<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Debug Login Test - BUMNag</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .section { margin-bottom: 30px; }
        .btn { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin: 5px; }
        .btn:hover { background: #0056b3; }
        .btn.danger { background: #dc3545; }
        .btn.danger:hover { background: #c82333; }
        .btn.success { background: #28a745; }
        .btn.success:hover { background: #1e7e34; }
        .result { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 15px; margin-top: 10px; }
        .success { background: #d4edda; border-color: #c3e6cb; color: #155724; }
        .error { background: #f8d7da; border-color: #f5c6cb; color: #721c24; }
        input, select { padding: 8px; margin: 5px; border: 1px solid #ccc; border-radius: 4px; width: 200px; }
        pre { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 4px; padding: 15px; overflow-x: auto; white-space: pre-wrap; }
        .loading { color: #6c757d; font-style: italic; }
        h1 { color: #dc3545; }
        h2 { color: #495057; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 4px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 BUMNag Debug Center</h1>
        <div class="warning">
            <strong>⚠️ PERINGATAN:</strong> Tool ini hanya untuk debugging. Hapus setelah production stabil!
        </div>

        <!-- System Information -->
        <div class="section">
            <h2>📊 System Information</h2>
            <button class="btn" onclick="getSystemInfo()">Get System Info</button>
            <div id="systemInfo" class="result" style="display:none;">
                <div class="loading">Loading...</div>
            </div>
        </div>

        <!-- Session Test -->
        <div class="section">
            <h2>🔄 Session Test</h2>
            <button class="btn" onclick="testSession()">Test Session Persistence</button>
            <div id="sessionTest" class="result" style="display:none;">
                <div class="loading">Loading...</div>
            </div>
        </div>

        <!-- Login Test -->
        <div class="section">
            <h2>🔐 Login Test</h2>
            <input type="email" id="loginEmail" placeholder="Email" value="admin@bumnag.com">
            <input type="password" id="loginPassword" placeholder="Password" value="password123">
            <br>
            <button class="btn" onclick="testLogin()">Test Login Credentials</button>
            <div id="loginTest" class="result" style="display:none;">
                <div class="loading">Loading...</div>
            </div>
        </div>

        <!-- Emergency Login -->
        <div class="section">
            <h2>🚨 Emergency Login</h2>
            <p>Jika login Filament tidak bekerja, gunakan ini untuk masuk langsung:</p>
            <input type="email" id="emergencyEmail" placeholder="Email" value="admin@bumnag.com">
            <input type="password" id="emergencyPassword" placeholder="Password" value="password123">
            <br>
            <button class="btn danger" onclick="emergencyLogin()">Emergency Login (Bypass Filament)</button>
            <div id="emergencyResult" class="result" style="display:none;">
                <div class="loading">Loading...</div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="section">
            <h2>🔗 Quick Links</h2>
            <a href="/admin" class="btn success">Go to Filament Admin</a>
            <a href="/admin/login" class="btn">Filament Login Page</a>
            <a href="/" class="btn">Home Page</a>
        </div>
    </div>

    <script>
        // Get CSRF token
        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.content || '';
        }

        async function getSystemInfo() {
            const resultDiv = document.getElementById('systemInfo');
            resultDiv.style.display = 'block';
            resultDiv.innerHTML = '<div class="loading">Loading system information...</div>';
            
            try {
                const response = await fetch('/debug', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                });
                
                if (!response.ok) {
                    const text = await response.text();
                    throw new Error(`HTTP ${response.status}: ${text.substring(0, 200)}`);
                }
                , {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                });
                
                if (!response.ok) {
                    const text = await response.text();
                    throw new Error(`HTTP ${response.status}: ${text.substring(0, 200)}`);
                }
                
                const data = await response.json();
                
                resultDiv.className = 'result success';
                resultDiv.innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
            } catch (error) {
                resultDiv.className = 'result error';
                resultDiv.innerHTML = `<strong>Error:</strong> ${error.message}`;
            }
        }

        async function testSession() {
            const resultDiv = document.getElementById('sessionTest');
            resultDiv.style.display = 'block';
            resultDiv.innerHTML = '<div class="loading">Testing session persistence...</div>';
            
            try {
                const response = await fetch('/debug/test-session');
                const data = await response.json();
                
                resultDiv.className = data.session_working ? 'result success' : 'result error';
                resultDiv.innerHTML = `
                    <h4>Session Test Results:</h4>
                    <p><strong>Session Working:</strong> ${data.session_working ? '✅ YES' : '❌ NO'}</p>
                    <p><strong>Session ID:</strong> ${data.session_id}</p>
                    <p><strong>Driver:</strong> ${data.session_driver}</p>
                    <p><strong>In Database:</strong> ${data.session_in_database ? 'Yes' : 'No'}</p>
                    <pre>${JSON.stringify(data, null, 2)}</pre>
                `;
            } catch (error) {
                resultDiv.className = 'result error';
                resultDiv.innerHTML = `<strong>Error:</strong> ${error.message}`;
            }
        }

        async function testLogin() {
            const email =Accept': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ email, password })
                });
                
                if (!response.ok) {
                    const text = await response.text();
                    throw new Error(`HTTP ${response.status}: ${text.substring(0, 200)}`);
                }
            resultDiv.style.display = 'block';
            resultDiv.innerHTML = '<div class="loading">Testing login credentials...</div>';
            
            try {
                const response = await fetch('/debug/test-login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ email, password })
                });
                
                const data = await response.json();
                
                resultDiv.className = data.success ? 'result success' : 'result error';
                resultDiv.innerHTML = `
                    <h4>Login Test Results:</h4>
                    <p><strong>Success:</strong> ${data.success ? '✅ YES' : '❌ NO'}</p>
                    ${data.steps ? `
                        <p><strong>Steps:</strong></p>
                        <ul>
                            <li>User Found: ${data.steps.user_found ? '✅' : '❌'}</li>
                            <li>Password Verified: ${data.steps.password_verified ? '✅' : '❌'}</li>
                            <li>Can Access Panel: ${data.steps.can_access_panel ? '✅' : '❌'}</li>
                            <li>Manual Login Success: ${data.steps.manual_login_success ? '✅' : '❌'}</li>
                        </ul>
                    ` : ''}
                    <pre>${JSON.stringify(data, null, 2)}</pre>
                `;
            } catch (error) {
                resultDiv.className = 'result error';
                resultDiv.innerHTML = `<strong>Error:</strong> ${error.message}`;
            }
        }

        async function emergencyLogin() {
            const email = document.getElementById('emergencyEmail').value;
            const password = document.getElementById('emergencyPassword').value;
            const resultDiv = document.getElementById('emergencyResult');
            
            resultDiv.styAccept': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'.innerHTML = '<div class="loading">Attempting emergency login...</div>';
            
            try {
                const response = await fetch('/debug/emergency-login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ email, password })
                });
                
                if (response.redirected) {
                    resultDiv.className = 'result success';
                    resultDiv.innerHTML = '<strong>✅ Emergency login successful! Redirecting to admin panel...</strong>';
                    setTimeout(() => {
                        window.location.href = response.url;
                    }, 2000);
                } else {
                    const data = await response.json();
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = `<strong>❌ Emergency login failed:</strong> ${data.error}`;
                }
            } catch (error) {
                resultDiv.className = 'result error';
                resultDiv.innerHTML = `<strong>Error:</strong> ${error.message}`;
            }
        }
    </script>
</body>
</html>