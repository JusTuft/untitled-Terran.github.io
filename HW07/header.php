<style>
    .header {
        background-color: #1a1a1a;
        color: #eeda4a;
        padding: 15px 30px;
        border-bottom: 3px solid #eeda4a;
        font-family: 'Arial', sans-serif;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .header .logo-link {
        display: flex; 
        align-items: center;
        text-decoration: none; 
        color: inherit; 
    }
    
    .header .logo-container {
        height: 125px;
        width: 125px;
        margin-right: 15px; 
        border-radius: 50%; 
        overflow: hidden;
    }
    
    .header .logo {
        height: 100%; 
        width: 100%;
        object-fit: cover;
        transform: scale(1.4);
    }

    .header h1 {
        margin: 0;
        font-size: 4em;
        font-weight: bold;
        color: #eeda4a; 
    }
    .header .details {
        text-align: right;
    }
    .header .details p {
        margin: 0;
        font-size: 1.1em;
        color: #fff;
    }
    .header .details a {
        color: #ff4500;
        text-decoration: none;
        font-size: 0.9em;
    }
    .header .details a:hover {
        text-decoration: underline;
    }
</style>

<div class="header">
    <a href="order_form.php" class="logo-link">
    <div class="logo-container">
        <img src="bin/logo.jpg" alt="The Mynock-Bite Diner Logo" class="logo">
    </div>
        <h1>The Mynock-Bite Diner</h1>
    </a>
    <div class="details">
        <p>Hours: 11am - 10pm</p>
        <a href="show_orders.php">Admin</a>
    </div>
</div>