<?php

$people = [
    [
        "name"      => "Ibtisam Safi",
        "role"      => "Developer",
        "skills"    => ["PHP", "Kotlin", "Python", "Clean Architecture"]
    ],
    [
        "name"      => "Sara Ali",
        "role"      => "Designer",
        "skills"    => ["UI/UX", "Figma", "Photoshop"]
    ],
    [
        "name"      => "Khaled Omar",
        "role"      => "Manager",
        "skills"    => ["Agile", "Scrum", "Leadership"]
    ],
    [
        "name"      => "Mona Sami",
        "role"      => "Analyst",
        "skills"    => ["Python", "Data BI", "Excel"]
    ],
    [
        "name"      => "Ziad Rami",
        "role"      => "Tester",
        "skills"    => ["Selenium", "QA Testing", "Jest"]
    ]
];

function renderCard(array $person): string {
    $cardColor = getCardColor($person['role']);
    $skillsList = implode(', ', $person['skills']);
    
    $html = '<div class="card">';
    $html .= '  <div class="card-color-bar" style="background-color: ' . $cardColor . ';"></div>';
    $html .= '  <div class="card-body">';
    $html .= '      <h3>' . htmlspecialchars($person['name']) . '</h3>';
    $html .= '      <span class="role" style="background-color: ' . $cardColor . '; color: #1a1a2e;">' . htmlspecialchars($person['role']) . '</span>';
    $html .= '      <div class="skills"><strong>Skills:</strong> ' . htmlspecialchars($skillsList) . '</div>';
    $html .= '  </div>';
    $html .= '</div>';
    
    return $html;
}

function getCardColor(string $role): string {
    return match($role) {
        "Developer" => "#7c4dff",
        "Designer"  => "#ff4081",
        "Manager"   => "#00bfa5",
        "Analyst"   => "#ff6d00",
        "Tester"    => "#2979ff",
        default     => "#757575",
    };
}

$searchQuery = $_GET["search"] ?? "";
if (!empty($searchQuery)) {
    $people = array_filter($people, function($person) use ($searchQuery) {
        return stripos($person["name"], $searchQuery) !== false;
    });
}

$totalPeople = count($people);
$currentDate = date("F j, Y");

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 01 - Profile Card Generator</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0f0f1a;
            color: #e0e0e0;
            line-height: 1.6;
            min-height: 100vh;
        }
        .header {
            background: linear-gradient(135deg, #1a1a2e, #2d1b3d);
            padding: 30px 20px;
            text-align: center;
            border-bottom: 3px solid #ce93d8;
        }
        .header .logo-row {
            display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 10px;
        }
        .header .university-title {
            color: #ccc; font-weight: 600; font-size: 1.1rem; letter-spacing: 0.5px;
        }
        .header h1 { font-size: 1.8rem; color: #fff; margin-bottom: 5px; }
        .header h1 span { color: #ce93d8; }
        .header p { color: #aaa; font-size: 0.95rem; }

        .container { max-width: 1100px; margin: 0 auto; padding: 30px 20px; }

        .stats {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .stat-box {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 15px 30px;
            text-align: center;
        }
        .stat-box .number { font-size: 2rem; font-weight: 800; color: #ce93d8; }
        .stat-box .label { font-size: 0.85rem; color: #888; }

        .search-form {
            text-align: center;
            margin-bottom: 30px;
        }
        .search-form input[type="text"] {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #e0e0e0;
            padding: 12px 20px;
            border-radius: 30px;
            font-size: 1rem;
            width: 300px;
            outline: none;
            font-family: 'Inter', sans-serif;
        }
        .search-form input[type="text"]:focus {
            border-color: #ce93d8;
        }
        .search-form button {
            background: #ce93d8;
            color: #1a1a2e;
            border: none;
            padding: 12px 24px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-left: 10px;
            font-family: 'Inter', sans-serif;
        }
        .search-form button:hover { background: #e1bee7; }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }
        .card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .card-color-bar { height: 5px; }
        .card-body { padding: 30px 25px; text-align: center; }
        .card-body h3 { color: #fff; font-size: 1.25rem; margin-bottom: 8px; }
        .card-body .role {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 15px;
        }
        .card-body .skills { color: #aaa; font-size: 0.85rem; text-align: left; background: rgba(0,0,0,0.15); padding: 10px; border-radius: 8px; }

        .no-results {
            text-align: center;
            padding: 50px 20px;
            color: #666;
            font-size: 1.1rem;
            grid-column: 1 / -1;
        }

        .footer {
            text-align: center;
            padding: 30px 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
            color: #555;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="logo-row">
        <span class="university-title">Al-Aqsa University</span>
    </div>
    <h1>Profile <span>Card Generator</span></h1>
    <p>Week 11 - Task 01: PHP Arrays, Functions & Loops</p>
</div>

<div class="container">

    <div class="stats">
        <div class="stat-box">
            <div class="number"><?php echo isset($totalPeople) ? $totalPeople : '?'; ?></div>
            <div class="label">Total People</div>
        </div>
        <div class="stat-box">
            <div class="number"><?php echo isset($currentDate) ? $currentDate : '?'; ?></div>
            <div class="label">Current Date</div>
        </div>
    </div>

    <form class="search-form" method="GET" action="">
        <input type="text" name="search" placeholder="Search by name..." value="<?php echo htmlspecialchars($searchQuery ?? ''); ?>">
        <button type="submit">Search</button>
    </form>

    <div class="cards-grid">
        <?php if (!empty($people)): ?>
            <?php foreach ($people as $person): ?>
                <?php echo renderCard($person); ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-results">
                <p>No people found. Try another search!</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<div class="footer">
    Al-Aqsa University - Web Development 1
</div>

</body>
</html>
