<?php
$url = "https://open.er-api.com/v6/latest/EUR"; 
$data = @file_get_contents($url);
$rates = json_decode($data, true);

$amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 1;
$from = isset($_POST['from_currency']) ? $_POST['from_currency'] : 'EUR';
$result = 0;

if ($rates && isset($rates['rates'])) {
    $eur_to_ron = (float)$rates['rates']['RON'];
    function getToRon($currencyCode, $rates, $eur_to_ron) {
        if (!isset($rates['rates'][$currencyCode])) return 0.0;
        return $eur_to_ron / (float)$rates['rates'][$currencyCode];
    }

    if (isset($_POST['convert'])) {
        $rate_to_ron = ($from === 'EUR') ? $eur_to_ron : getToRon($from, $rates, $eur_to_ron);
        $result = $amount * $rate_to_ron;
    }
}
?>
<div class="floating-video-card">
    <div class="video-header">
        <span><i class="fas fa-play-circle"></i>    Money moneyyy $$</span>
        <button onclick="this.parentElement.parentElement.style.display='none'">&times;</button>
    </div>
    <div class="video-body">
        <video autoplay muted loop playsinline>
            <source src="currency.mp4" type="video/mp4">
        </video>
    </div>
</div>

<div class="card">
    <div class="card-header" style="margin-bottom: 20px;">
        <h2 style="color: #6c5ce7;"><i class="fas fa-globe-americas"></i> Global Currency Converter</h2>
        <p style="color: #636e72;">Convert international money directly to <strong>Lei (RON)</strong>.</p>
    </div>

    <form method="POST" action="dashboard.php?page=currency" style="display: flex; flex-direction: column; gap: 15px;">
        
        <div class="input-field">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Amount to Convert</label>
            <input type="number" name="amount" step="0.01" value="<?php echo $amount; ?>" placeholder="0.00" required 
                   style="width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #dddfe2; background: #f5f6f7;">
        </div>

        <div class="input-field">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Select Source Currency</label>
            <select name="from_currency" style="width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #dddfe2; background: #f5f6f7;">
                <optgroup label="Popular">
                    <option value="EUR" <?php echo ($from == 'EUR') ? 'selected' : ''; ?>>Euro (EUR)</option>
                    <option value="USD" <?php echo ($from == 'USD') ? 'selected' : ''; ?>>US Dollar (USD)</option>
                    <option value="GBP" <?php echo ($from == 'GBP') ? 'selected' : ''; ?>>British Pound (GBP)</option>
                </optgroup>
                <optgroup label="Asia & Pacific">
                    <option value="CNY" <?php echo ($from == 'CNY') ? 'selected' : ''; ?>>Chinese Yuan (CNY)</option>
                    <option value="JPY" <?php echo ($from == 'JPY') ? 'selected' : ''; ?>>Japanese Yen (JPY)</option>
                    <option value="AUD" <?php echo ($from == 'AUD') ? 'selected' : ''; ?>>Australian Dollar (AUD)</option>
                    <option value="INR" <?php echo ($from == 'INR') ? 'selected' : ''; ?>>Indian Rupee (INR)</option>
                    <option value="KRW" <?php echo ($from == 'KRW') ? 'selected' : ''; ?>>South Korean Won (KRW)</option>
                </optgroup>
                <optgroup label="Others">
                    <option value="CHF" <?php echo ($from == 'CHF') ? 'selected' : ''; ?>>Swiss Franc (CHF)</option>
                    <option value="CAD" <?php echo ($from == 'CAD') ? 'selected' : ''; ?>>Canadian Dollar (CAD)</option>
                    <option value="AED" <?php echo ($from == 'AED') ? 'selected' : ''; ?>>UAE Dirham (AED)</option>
                    <option value="TRY" <?php echo ($from == 'TRY') ? 'selected' : ''; ?>>Turkish Lira (TRY)</option>
                    <option value="BRL" <?php echo ($from == 'BRL') ? 'selected' : ''; ?>>Brazilian Real (BRL)</option>
                </optgroup>
            </select>
        </div>

        <button type="submit" name="convert" class="btn-save" style="margin-top: 10px; padding: 15px;">
            <i class="fas fa-sync-alt"></i> Convert to Lei
        </button>
    </form>

    <?php if (isset($_POST['convert'])): ?>
        <div class="result-box" style="margin-top: 30px; padding: 30px; background: #f8f9fa; border-radius: 20px; text-align: center; border: 2px dashed #6c5ce7;">
            <p style="color: #636e72; font-size: 0.9rem; letter-spacing: 1px; margin-bottom: 5px;">TOTAL IN ROMANIAN LEI</p>
            <h1 style="color: #6c5ce7; font-size: 3rem; margin: 0;">
                <?php echo number_format($result, 2); ?> <span style="font-size: 1.5rem;">lei</span>
            </h1>
            <p style="margin-top: 10px; font-size: 0.85rem; color: #95a5a6;">
                Rate: 1 <?php echo $from; ?> = <?php echo number_format($result / $amount, 4); ?> RON
            </p>
        </div>
    <?php endif; ?>
</div>