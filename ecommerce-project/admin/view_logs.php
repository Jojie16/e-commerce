<?php
$pageTitle = "View Logs";
require_once 'admin_header.php';
?>

<div class="view-logs">
    <h2>Customer Activity Logs</h2>
    
    <div class="logs-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Activity</th>
                    <th>IP Address</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <!-- In a real application, you would fetch logs from a database -->
                <tr>
                    <td>1</td>
                    <td>John Doe (john@example.com)</td>
                    <td>Logged in</td>
                    <td>192.168.1.1</td>
                    <td>2023-06-15 10:30:45</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jane Smith (jane@example.com)</td>
                    <td>Placed order #1001</td>
                    <td>192.168.1.2</td>
                    <td>2023-06-15 11:15:22</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>John Doe (john@example.com)</td>
                    <td>Updated profile</td>
                    <td>192.168.1.1</td>
                    <td>2023-06-15 12:05:33</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Robert Johnson (robert@example.com)</td>
                    <td>Registered account</td>
                    <td>192.168.1.3</td>
                    <td>2023-06-15 14:20:18</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Jane Smith (jane@example.com)</td>
                    <td>Logged out</td>
                    <td>192.168.1.2</td>
                    <td>2023-06-15 15:45:10</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once '../includes/footer.php';
?>