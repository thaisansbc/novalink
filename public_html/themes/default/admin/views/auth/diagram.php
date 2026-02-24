<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    /* --- Tree Container --- */
    .tree-container {
        width: 100%;
        overflow-x: auto;
        padding: 40px 20px;
        background: #f8fafc;
        text-align: center;
    }

    .tree {
        display: inline-block;
        white-space: nowrap;
    }

    .tree ul {
        padding-top: 25px;
        position: relative;
        display: flex;
        justify-content: center;
    }

    .tree li {
        float: left;
        text-align: center;
        list-style-type: none;
        position: relative;
        padding: 25px 10px 0 10px;
    }

    /* --- Connecting Lines (Pink/Red) --- */
    .tree li::before, .tree li::after {
        content: '';
        position: absolute;
        top: 0;
        right: 50%;
        border-top: 2px solid #e38d8d;
        width: 50%;
        height: 25px;
    }
    .tree li::after {
        right: auto;
        left: 50%;
        border-left: 2px solid #e38d8d;
    }
    .tree li:only-child::after, .tree li:only-child::before { display: none; }
    .tree li:only-child { padding-top: 0; }
    .tree li:first-child::before, .tree li:last-child::after { border: 0 none; }
    .tree li:last-child::before { border-right: 2px solid #e38d8d; border-radius: 0 5px 0 0; }
    .tree li:first-child::after { border-radius: 5px 0 0 0; }
    .tree ul ul::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        border-left: 2px solid #e38d8d;
        height: 25px;
    }

    /* --- Node Box (The Person Card) --- */
    .node-card {
        background: white;
        border: 1px solid #e38d8d;
        border-radius: 6px;
        display: inline-block;
        min-width: 160px;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        overflow: hidden;
        font-family: sans-serif;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .node-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .node-card.qualified {
        border: 2px solid #27ae60;
        background: linear-gradient(135deg, #f0fff0 0%, #ffffff 100%);
    }
    
    .node-card.not-qualified {
        border: 2px solid #e74c3c;
        background: #fff0f0;
    }

    .node-header {
        background: #e38d8d;
        color: white;
        font-size: 12px;
        font-weight: bold;
        padding: 5px 8px;
        position: relative;
    }

    .qualified-star {
        position: absolute;
        right: 5px;
        top: 3px;
        font-size: 14px;
        color: #f1c40f;
    }

    .node-name {
        padding: 8px 5px;
        color: #b91c1c;
        font-weight: 700;
        font-size: 13px;
        border-bottom: 1px solid #f3f4f6;
    }

    .node-rank {
        font-size: 11px;
        color: #7f8c8d;
        padding: 2px 5px;
        background: #f8f9fa;
        font-style: italic;
    }

    .node-pv {
        font-size: 11px;
        color: #e67e22;
        font-weight: bold;
        padding: 2px 5px;
        background: #fff3e0;
    }

    /* --- Stats Section (Combo, Standard, Total) --- */
    .node-stats {
        display: flex;
        background: #fff;
        border-top: 1px solid #f3f4f6;
    }

    .stat-item {
        flex: 1;
        padding: 4px 2px;
        border-right: 1px solid #f3f4f6;
        text-align: center;
    }

    .stat-item:last-child { border-right: none; }

    .stat-label {
        font-size: 9px;
        font-weight: bold;
        display: block;
        margin-bottom: 2px;
    }

    .stat-val {
        font-size: 11px;
        font-weight: bold;
        color: #374151;
    }

    /* Labels for C, S */
    .lbl-c { color: #9333ea; } /* Purple for Combo */
    .lbl-s { color: #2563eb; } /* Blue for Standard */

    /* Matching Bonus Info */
    .matching-bonus-info {
        font-size: 9px;
        color: #8e44ad;
        padding: 3px 5px;
        background: #f3e5f5;
        border-top: 1px dashed #d1c4e9;
        text-align: center;
    }

    /* Binary Performance Info */
    .binary-info {
        font-size: 9px;
        color: #2980b9;
        padding: 3px 5px;
        background: #e1f5fe;
        border-top: 1px dashed #b3e5fc;
        text-align: center;
    }

    /* Commission Indicators */
    .commission-indicators {
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 3px;
        background: white;
        padding: 2px 6px;
        border-radius: 12px;
        border: 1px solid #ddd;
        white-space: nowrap;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .commission-badge {
        display: inline-block;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        color: white;
        font-size: 10px;
        line-height: 18px;
        text-align: center;
        cursor: help;
        font-weight: bold;
    }

    .commission-badge.exec { background: #9b59b6; }
    .commission-badge.binary { background: #3498db; }
    .commission-badge.matching { background: #8e44ad; }
    .commission-badge.direct { background: #27ae60; }
    .commission-badge.leader { background: #f39c12; }

    /* Main User Card */
    .main-user-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .main-user-card h4 {
        margin: 0 0 15px 0;
        color: white;
        font-size: 18px;
    }

    .qualification-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .qualification-badges .badge {
        background: rgba(255,255,255,0.2);
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 13px;
        border: 1px solid rgba(255,255,255,0.3);
    }

    /* Commission Legend */
    .commission-legend {
        margin-top: 30px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #3498db;
    }

    .commission-legend h5 {
        margin-top: 0;
        color: #2c3e50;
        font-size: 16px;
    }

    .legend-items {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin: 15px 0;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
    }

    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 4px;
    }

    .legend-color.exec-bg { background: #9b59b6; }
    .legend-color.direct-bg { background: #27ae60; }
    .legend-color.binary-bg { background: #3498db; }
    .legend-color.matching-bg { background: #8e44ad; }

    .qualification-icons {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #ddd;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .icon-qualified { color: #f1c40f; font-weight: bold; }
    .icon-pv { color: #27ae60; font-weight: bold; }
    .icon-legs { color: #3498db; font-weight: bold; }

    /* Binary Summary */
    .binary-summary {
        margin-top: 20px;
        padding: 15px;
        background: #e8f4fd;
        border-radius: 8px;
        border: 1px solid #b8e0ff;
    }

    .binary-summary h5 {
        margin-top: 0;
        color: #2c3e50;
    }

    .binary-stats {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .binary-stat {
        background: white;
        padding: 10px 15px;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .binary-stat-label {
        font-size: 11px;
        color: #7f8c8d;
        display: block;
    }

    .binary-stat-value {
        font-size: 16px;
        font-weight: bold;
        color: #2c3e50;
    }
</style>

<!-- Filter Form -->
<div class="row" style="margin-bottom: 20px;">
    <div class="col-md-12">
        <?= admin_form_open('auth/diagram/'.$id); ?>
        <div class="row">
            <div class="col-sm-3">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control" value="<?= $this->input->post('start_date') ?: date('Y-m-01') ?>">
            </div>
            <div class="col-sm-6">
                <label>Sales Per Week</label><br>
                <div class="btn-group">
                    <button type="submit" name="week" value="1" class="btn btn-primary">1 Week</button>
                    <button type="submit" name="week" value="2" class="btn btn-info">2 Weeks</button>
                    <button type="submit" name="week" value="3" class="btn btn-warning">3 Weeks</button>
                    <button type="submit" name="week" value="4" class="btn btn-success">4 Weeks</button>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>

<!-- Main User Info Card -->
<div class="main-user-card">
    <h4>Distributor: <?= $user->first_name . ' ' . ($user->last_name ?? '') ?></h4>
    <div class="qualification-badges">
        <span class="badge <?= ($user_qualification->is_fully_qualified ?? false) ? 'bg-success' : 'bg-danger' ?>">
            <?= ($user_qualification->is_fully_qualified ?? false) ? '✓ Fully Qualified' : '✗ Not Fully Qualified' ?>
        </span>
        <span class="badge bg-info">Rank: <?= $user_rank->rank_name ?? 'Bronze' ?></span>
        <span class="badge bg-warning">PV: <?= $user_qualification->pv ?? 0 ?> / 50</span>
        <span class="badge bg-secondary">
            Legs: <?= ($user_qualification->left_active ?? false) ? '1L' : '0L' ?> / <?= ($user_qualification->right_active ?? false) ? '1R' : '0R' ?>
        </span>
        <?php if(isset($user_binary_perf) && $user_binary_perf->eligible): ?>
            <span class="badge bg-success">Binary Eligible</span>
        <?php endif; ?>
    </div>
</div>

<!-- Binary Performance Summary -->
<?php if(isset($user_binary_perf) && $user_binary_perf->eligible): ?>
<div class="binary-summary">
    <h5>Binary Performance Summary</h5>
    <div class="binary-stats">
        <div class="binary-stat">
            <span class="binary-stat-label">Left Leg BV</span>
            <span class="binary-stat-value"><?= number_format($user_binary_perf->left_bv) ?></span>
        </div>
        <div class="binary-stat">
            <span class="binary-stat-label">Right Leg BV</span>
            <span class="binary-stat-value"><?= number_format($user_binary_perf->right_bv) ?></span>
        </div>
        <div class="binary-stat">
            <span class="binary-stat-label">Weak Leg BV</span>
            <span class="binary-stat-value"><?= number_format($user_binary_perf->weak_leg_bv) ?></span>
        </div>
        <div class="binary-stat">
            <span class="binary-stat-label">Potential Bonus</span>
            <span class="binary-stat-value">$<?= number_format($user_binary_perf->potential_bonus, 2) ?></span>
        </div>
        <div class="binary-stat">
            <span class="binary-stat-label">Carry Forward</span>
            <span class="binary-stat-value"><?= number_format($user_binary_perf->carry_forward) ?> BV</span>
        </div>
    </div>
</div>
<?php endif; ?>

<hr>

<!-- Binary Tree -->
<div class="tree-container">
    <div class="tree">
        <ul>
            <li>
                <!-- Root Node (Main User) -->
                <div class="node-card <?= ($user_qualification->is_fully_qualified ?? false) ? 'qualified' : '' ?>">
                    <div class="node-header">
                        LV.0
                        <?php if($user_qualification->is_fully_qualified ?? false): ?>
                            <span class="qualified-star" title="Fully Qualified">⭐</span>
                        <?php endif; ?>
                    </div>
                    <div class="node-name"><?= $user->first_name ?></div>
                    <div class="node-rank"><?= $user_rank->rank_name ?? 'Bronze' ?></div>
                    <div class="node-pv">PV: <?= $user_qualification->pv ?? 0 ?></div>
                    <div class="node-stats">
                        <div class="stat-item">
                            <span class="stat-label lbl-t">TOT</span>
                            <span class="stat-val">0</span>
                        </div>
                    </div>
                    
                    <!-- Commission indicators for root user -->
                    <div class="commission-indicators">
                        <?php if($user_qualification->is_fully_qualified ?? false): ?>
                            <span class="commission-badge exec" title="Executive Qualification Eligible">E</span>
                        <?php endif; ?>
                        <?php if(isset($user_binary_perf) && $user_binary_perf->eligible): ?>
                            <span class="commission-badge binary" title="Binary Performance Eligible">B</span>
                        <?php endif; ?>
                        <?php if(($user_qualification->meets_rank_requirements ?? false)): ?>
                            <span class="commission-badge matching" title="Matching Bonus Eligible">M</span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($bv_tree): ?>
                    <ul>
                        <?php 
                        // Start recursive rendering
                        renderEnhancedBinaryTree($bv_tree); 
                        ?>
                    </ul>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</div>

<!-- Commission Legend -->
<div class="commission-legend">
    <h5>Commission Types & Requirements:</h5>
    <div class="legend-items">
        <div class="legend-item">
            <span class="legend-color exec-bg"></span>
            <span><strong>Executive Qualification (E)</strong> - $50 (Requires Fully Qualified, 50+ PV, 2 active legs)</span>
        </div>
        <div class="legend-item">
            <span class="legend-color direct-bg"></span>
            <span><strong>Strategic Enrollment (D)</strong> - Based on Package (Bronze/Silver: $20, Gold/Platinum: $40, Sapphire+: $100)</span>
        </div>
        <div class="legend-item">
            <span class="legend-color binary-bg"></span>
            <span><strong>Binary Performance (B)</strong> - Team Bonus (Requires fully qualified, 500+ BV on weak leg)</span>
        </div>
        <div class="legend-item">
            <span class="legend-color matching-bg"></span>
            <span><strong>Matching Bonus (M)</strong> - Based on rank and downline performance</span>
        </div>
    </div>
    <div class="qualification-icons">
        <span class="icon-qualified">⭐ Fully Qualified (2 active legs + 50+ PV)</span>
        <span class="icon-pv">🔋 50+ PV Required for Active Status</span>
        <span class="icon-legs">🔄 2 Active Legs Required for Binary</span>
    </div>
</div>

<?php
function renderEnhancedBinaryTree($node) {
    if (!$node) return;
    
    // Render LEFT CHILD
    if ($node['left_name'] || !empty($node['left'])) {
        $l_combo = $node['combo_left'] ?? 0;
        $l_standard = $node['standard_left'] ?? 0;
        $l_total = $l_combo + $l_standard;
        $l_qual = $node['left_qualification'] ?? null;
        $l_binary = $node['left_binary_perf'] ?? null;
        $l_config = $node['left_bonus_config'] ?? null;
        $l_package = $node['left_package'] ?? null;
        
        $card_class = 'node-card';
        if ($l_qual && $l_qual->is_fully_qualified) {
            $card_class .= ' qualified';
        } elseif ($l_qual && !$l_qual->is_fully_qualified) {
            $card_class .= ' not-qualified';
        }
        
        echo '<li>';
        echo '<div class="' . $card_class . '">';
        
        // Header with BV
        echo '<div class="node-header">';
        echo number_format($l_total) . ' BV';
        if ($l_qual && $l_qual->is_fully_qualified) {
            echo '<span class="qualified-star" title="Fully Qualified">⭐</span>';
        }
        echo '</div>';
        
        // Member info
        echo '<div class="node-name">' . htmlspecialchars($node['left_name']) . '</div>';
        echo '<div class="node-rank">' . ($l_qual->rank ?? 'Bronze') . '</div>';
        echo '<div class="node-pv">PV: ' . ($l_qual->pv ?? 0) . '</div>';
        
        // BV breakdown
        echo '<div class="node-stats">';
        echo '<div class="stat-item"><span class="stat-label lbl-c">C</span><span class="stat-val">' . number_format($l_combo) . '</span></div>';
        echo '<div class="stat-item"><span class="stat-label lbl-s">S</span><span class="stat-val">' . number_format($l_standard) . '</span></div>';
        echo '</div>';
        
        // Matching bonus info
        if ($l_config) {
            echo '<div class="matching-bonus-info">';
            echo 'MB: L1:' . $l_config->level1 . '%';
            if ($l_config->level2 && $l_config->level2 != 'NULL') echo ' | L2:' . $l_config->level2 . '%';
            if ($l_config->level3 && $l_config->level3 != 'NULL') echo ' | L3:' . $l_config->level3 . '%';
            if ($l_config->level4 && $l_config->level4 != 'NULL') echo ' | L4:' . $l_config->level4 . '%';
            if ($l_config->level5 && $l_config->level5 != 'NULL') echo ' | L5:' . $l_config->level5 . '%';
            echo '</div>';
        }
        
        // Binary performance
        if ($l_binary && $l_binary->eligible) {
            echo '<div class="binary-info">';
            echo 'Weak: ' . number_format($l_binary->weak_leg_bv) . ' BV | ';
            echo 'Carry: ' . number_format($l_binary->carry_forward) . ' BV';
            echo '</div>';
        }
        
        // Commission indicators
        echo '<div class="commission-indicators">';
        if ($l_qual && $l_qual->is_fully_qualified) {
            echo '<span class="commission-badge exec" title="Executive Qualification Eligible">E</span>';
            if ($l_total >= 500) {
                echo '<span class="commission-badge binary" title="Binary Performance Eligible">B</span>';
            }
        }
        if ($l_qual && ($l_qual->meets_rank_requirements ?? false)) {
            echo '<span class="commission-badge matching" title="Matching Bonus Eligible">M</span>';
        }
        if ($l_package) {
            $bonus = $l_package->commission_amount ?? 0;
            echo '<span class="commission-badge direct" title="Direct Bonus: $' . number_format($bonus) . '">D</span>';
        }
        echo '</div>';
        
        echo '</div>';

        if (!empty($node['left'])) {
            echo '<ul>';
            renderEnhancedBinaryTree($node['left']);
            echo '</ul>';
        }
        echo '</li>';
    }

    // Render RIGHT CHILD
    if ($node['right_name'] || !empty($node['right'])) {
        $r_combo = $node['combo_right'] ?? 0;
        $r_standard = $node['standard_right'] ?? 0;
        $r_total = $r_combo + $r_standard;
        $r_qual = $node['right_qualification'] ?? null;
        $r_binary = $node['right_binary_perf'] ?? null;
        $r_config = $node['right_bonus_config'] ?? null;
        $r_package = $node['right_package'] ?? null;

        $card_class = 'node-card';
        if ($r_qual && $r_qual->is_fully_qualified) {
            $card_class .= ' qualified';
        } elseif ($r_qual && !$r_qual->is_fully_qualified) {
            $card_class .= ' not-qualified';
        }

        echo '<li>';
        echo '<div class="' . $card_class . '">';
        
        echo '<div class="node-header">';
        echo number_format($r_total) . ' BV';
        if ($r_qual && $r_qual->is_fully_qualified) {
            echo '<span class="qualified-star" title="Fully Qualified">⭐</span>';
        }
        echo '</div>';
        
        echo '<div class="node-name">' . htmlspecialchars($node['right_name']) . '</div>';
        echo '<div class="node-rank">' . ($r_qual->rank ?? 'Bronze') . '</div>';
        echo '<div class="node-pv">PV: ' . ($r_qual->pv ?? 0) . '</div>';
        
        echo '<div class="node-stats">';
        echo '<div class="stat-item"><span class="stat-label lbl-c">C</span><span class="stat-val">' . number_format($r_combo) . '</span></div>';
        echo '<div class="stat-item"><span class="stat-label lbl-s">S</span><span class="stat-val">' . number_format($r_standard) . '</span></div>';
        echo '</div>';
        
        if ($r_config) {
            echo '<div class="matching-bonus-info">';
            echo 'MB: L1:' . $r_config->level1 . '%';
            if ($r_config->level2 && $r_config->level2 != 'NULL') echo ' | L2:' . $r_config->level2 . '%';
            if ($r_config->level3 && $r_config->level3 != 'NULL') echo ' | L3:' . $r_config->level3 . '%';
            if ($r_config->level4 && $r_config->level4 != 'NULL') echo ' | L4:' . $r_config->level4 . '%';
            if ($r_config->level5 && $r_config->level5 != 'NULL') echo ' | L5:' . $r_config->level5 . '%';
            echo '</div>';
        }
        
        if ($r_binary && $r_binary->eligible) {
            echo '<div class="binary-info">';
            echo 'Weak: ' . number_format($r_binary->weak_leg_bv) . ' BV | ';
            echo 'Carry: ' . number_format($r_binary->carry_forward) . ' BV';
            echo '</div>';
        }
        
        echo '<div class="commission-indicators">';
        if ($r_qual && $r_qual->is_fully_qualified) {
            echo '<span class="commission-badge exec" title="Executive Qualification Eligible">E</span>';
            if ($r_total >= 500) {
                echo '<span class="commission-badge binary" title="Binary Performance Eligible">B</span>';
            }
        }
        if ($r_qual && ($r_qual->meets_rank_requirements ?? false)) {
            echo '<span class="commission-badge matching" title="Matching Bonus Eligible">M</span>';
        }
        if ($r_package) {
            $bonus = $r_package->commission_amount ?? 0;
            echo '<span class="commission-badge direct" title="Direct Bonus: $' . number_format($bonus) . '">D</span>';
        }
        echo '</div>';
        
        echo '</div>';

        if (!empty($node['right'])) {
            echo '<ul>';
            renderEnhancedBinaryTree($node['right']);
            echo '</ul>';
        }
        echo '</li>';
    }
}
?>