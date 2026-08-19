<?php
$quotes = [
    ["type" => "MOTIVATION", "text" => "Small progress is still progress.", "color" => "#6c5ce7"],
    ["type" => "DID YOU KNOW", "text" => "Mount Everest is the highest mountain on Earth.", "color" => "#00b894"],
    ["type" => "MOTIVATION", "text" => "Don't stop until you're proud.", "color" => "#e17055"],
    ["type" => "DID YOU KNOW", "text" => "Honey never spoils.", "color" => "#fbc531"],
    ["type" => "REASONING", "text" => "Everything happens for a reason. Usually, the reason is I'm stupid.", "color" => "#ff7675"],
    ["type" => "ADULTING", "text" => "Adulting is like looking for a matching sock in a dark room.", "color" => "#74b9ff"],
    ["type" => "HONESTY", "text" => "I’m not lazy, I’m just on energy saving mode.", "color" => "#fdcb6e"],
    ["type" => "DIET TIPS", "text" => "I followed my heart and it led me to the fridge.", "color" => "#e84393"],
    ["type" => "WORK LIFE", "text" => "Doing nothing is hard, you never know when you're finished.", "color" => "#55efc4"],
    ["type" => "FINANCE", "text" => "My wallet is like an onion. Opening it makes me cry.", "color" => "#d63031"],
    ["type" => "WISDOM", "text" => "Common sense is like deodorant. The people who need it most never use it.", "color" => "#a29bfe"],
    ["type" => "PRODUCTIVITY", "text" => "I put the 'pro' in procrastination. And by 'pro' I mean 'please help me.'", "color" => "#fab1a0"], // Fixed missing comma here!
    
    // --- RELATABLE HUMAN MOMENTS ---
    ["type" => "SOCIETY", "text" => "I don't need a hair stylist, my pillow gives me a new hairstyle every morning.", "color" => "#fd79a8"],
    ["type" => "GENIUS", "text" => "I’m not a complete idiot. Some parts are missing.", "color" => "#00cec9"],
    ["type" => "LIFE SKILLS", "text" => "My ability to turn a 5-minute task into a 3-day project is unmatched.", "color" => "#6c5ce7"],
    ["type" => "EXERCISE", "text" => "I do marathons. On Netflix.", "color" => "#e17055"],
    ["type" => "MYSTERY", "text" => "Where does all my money go? It's like I'm paying for a lifestyle I don't even have.", "color" => "#d63031"],
    ["type" => "NIGHT OWL", "text" => "I'm not a morning person. I'm not even a 'person' until noon.", "color" => "#a29bfe"],
    ["type" => "COOKING", "text" => "I make wine disappear. What’s your superpower?", "color" => "#e84393"],
    
    // --- TECH & INTERNET ---
    ["type" => "WIFI", "text" => "Home is where the WiFi connects automatically.", "color" => "#0984e3"],
    ["type" => "PASSWORD", "text" => "Your password must contain a capital letter, a number, a symbol, and a piece of your soul.", "color" => "#2d3436"],
    ["type" => "ERROR", "text" => "To err is human, but to really foul things up you need a computer.", "color" => "#d63031"],
    ["type" => "AI", "text" => "I’m not afraid of Artificial Intelligence. I’m afraid of Natural Stupidity.", "color" => "#00b894"],
    
    // ---  THE OFFICE ---
    ["type" => "MEETINGS", "text" => "I survived another meeting that should have been an email.", "color" => "#636e72"],
    ["type" => "WORK", "text" => "If you think your job is hard, try being a piece of hardware in my house.", "color" => "#74b9ff"],
    ["type" => "RETIREMENT", "text" => "I have enough money to last me for the rest of my life. Provided I die next Tuesday.", "color" => "#fdcb6e"],
    
    // ---PHILOSOPHY ---
    ["type" => "TRUTH", "text" => "The road to success is always under construction.", "color" => "#e17055"],
    ["type" => "LOGIC", "text" => "Why is it called 'Quick Sand' if it takes you forever to sink?", "color" => "#ffeaa7"],
    ["type" => "THOUGHTS", "text" => "If 'Plan A' fails, remember there are 25 more letters in the alphabet.", "color" => "#00cec9"],
    ["type" => "WISDOM", "text" => "Knowledge is knowing a tomato is a fruit. Wisdom is not putting it in a fruit salad.", "color" => "#fd79a8"]
];

$random_quote = $quotes[array_rand($quotes)];
?>

<div class="motivation-container" style="border-left: 6px solid <?php echo $random_quote['color']; ?>; padding: 20px; background: #fff; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin: 20px 0;">
    <span class="motivation-label" style="color: <?php echo $random_quote['color']; ?>; font-weight: bold; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">
        <i class="fas fa-lightbulb"></i> <?php echo htmlspecialchars($random_quote['type']); ?>
    </span>
    <p class="quote-text" style="font-size: 1.1rem; color: #2d3436; margin-top: 10px; font-style: italic; line-height: 1.5;">
        "<?php echo nl2br(htmlspecialchars($random_quote['text'])); ?>"
    </p>
</div>