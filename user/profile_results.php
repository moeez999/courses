<?php
$sql = "SELECT gi.id, gi.itemname, gi.itemmodule, gi.iteminstance, 
               gi.courseid, c.fullname as coursename,
               gg.finalgrade, gg.rawgrademax, gg.feedback,
               FROM_UNIXTIME(gg.timemodified) as gradeddate
        FROM {grade_items} gi
        JOIN {grade_grades} gg ON gg.itemid = gi.id
        JOIN {course} c ON c.id = gi.courseid
        WHERE gg.userid = :userid
        AND gi.itemmodule IN ('quiz', 'assign', 'exam')
        ORDER BY c.fullname, gi.itemmodule, gi.itemname";

$params = ['userid' => $USER->id];
$activities = $DB->get_records_sql($sql, $params);

// Organize by activity type
$exams = array_filter($activities, fn($a) => $a->itemmodule == 'exam');
$quizzes = array_filter($activities, fn($a) => $a->itemmodule == 'quiz');
$assignments = array_filter($activities, fn($a) => $a->itemmodule == 'assign');

echo '
<div class="row">
    <div class="col-lg-7 col-md-12">
        <section class="profile-card">
            <div class="profile-card-header">
                <h2>' . get_string('results', 'core_user') . '</h2>
                <div class="tabs">
                    <button class="tab-btn active" data-tab="exams">' . get_string('exams', 'core_user') . '</button>
                    <button class="tab-btn" data-tab="quizzes">' . get_string('quizzes', 'core_user') . '</button>
                    <button class="tab-btn" data-tab="homework">' . get_string('homework', 'core_user') . '</button>
                </div>
            </div>
            
            <!-- Exams Tab Content -->
            <div class="tab-content active" id="exams-tab">
                <div class="accordion">';

if (empty($exams)) {
    echo '<div class="no-results">' . get_string('noexams', 'core_user') . '</div>';
} else {
    foreach ($exams as $exam) {
        $percentage = $exam->rawgrademax ? round(($exam->finalgrade / $exam->rawgrademax) * 100) : 0;
        
        echo '
        <div class="accordion-item">
            <div class="accordion-header">
                <span>' . format_string($exam->itemname) . '</span>
                <div class="exam-meta">
                    <span class="score">' . $exam->finalgrade . '/' . $exam->rawgrademax . '</span>
                    <span class="percentage">' . $percentage . '%</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="accordion-content">
                <div class="result-details">
                    <div class="detail-row">
                        <span>' . get_string('course') . ':</span>
                        <span>' . format_string($exam->coursename) . '</span>
                    </div>
                    <div class="detail-row">
                        <span>' . get_string('maxmarks', 'grades') . ':</span>
                        <span>' . $exam->rawgrademax . '</span>
                    </div>
                    <div class="detail-row">
                        <span>' . get_string('obtained', 'grades') . ':</span>
                        <span>' . $exam->finalgrade . '</span>
                    </div>
                    <div class="detail-row">
                        <span>' . get_string('percentage', 'grades') . ':</span>
                        <span>' . $percentage . '%</span>
                    </div>
                    <div class="detail-row">
                        <span>' . get_string('gradedon', 'grades') . ':</span>
                        <span>' . $exam->gradeddate . '</span>
                    </div>
                </div>
                <div class="result-chart">
                    <div class="chart-bar" style="width: ' . $percentage . '%;"></div>
                </div>
                ' . (!empty($exam->feedback) ? '<div class="feedback"><strong>' . get_string('feedback', 'assign') . ':</strong> ' . format_text($exam->feedback) . '</div>' : '') . '
            </div>
        </div>';
    }
}

echo '
                </div>
            </div>
            
            <!-- Quizzes Tab Content -->
            <div class="tab-content" id="quizzes-tab" style="display:none;">
                <div class="accordion">';
                
if (empty($quizzes)) {
    echo '<div class="no-results">' . get_string('noquizzes', 'core_user') . '</div>';
} else {
    foreach ($quizzes as $quiz) {
        $percentage = $quiz->rawgrademax ? round(($quiz->finalgrade / $quiz->rawgrademax) * 100) : 0;
        
        echo '
        <div class="accordion-item">
            <div class="accordion-header">
                <span>' . format_string($quiz->itemname) . '</span>
                <div class="exam-meta">
                    <span class="score">' . $quiz->finalgrade . '/' . $quiz->rawgrademax . '</span>
                    <span class="percentage">' . $percentage . '%</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="accordion-content">
                <div class="result-details">
                    <div class="detail-row">
                        <span>' . get_string('course') . ':</span>
                        <span>' . format_string($quiz->coursename) . '</span>
                    </div>
                    <div class="detail-row">
                        <span>' . get_string('maxmarks', 'grades') . ':</span>
                        <span>' . $quiz->rawgrademax . '</span>
                    </div>
                    <div class="detail-row">
                        <span>' . get_string('obtained', 'grades') . ':</span>
                        <span>' . $quiz->finalgrade . '</span>
                    </div>
                    <div class="detail-row">
                        <span>' . get_string('percentage', 'grades') . ':</span>
                        <span>' . $percentage . '%</span>
                    </div>
                    <div class="detail-row">
                        <span>' . get_string('gradedon', 'grades') . ':</span>
                        <span>' . $quiz->gradeddate . '</span>
                    </div>
                </div>
                <div class="result-chart">
                    <div class="chart-bar" style="width: ' . $percentage . '%;"></div>
                </div>
                ' . (!empty($quiz->feedback) ? '<div class="feedback"><strong>' . get_string('feedback', 'assign') . ':</strong> ' . format_text($quiz->feedback) . '</div>' : '') . '
            </div>
        </div>';
    }
}

echo '
                </div>
            </div>
            
            <!-- Homework Tab Content -->
            <div class="tab-content" id="homework-tab" style="display:none;">
                <div class="accordion">';
                
if (empty($assignments)) {
    echo '<div class="no-results">' . get_string('noassignments', 'core_user') . '</div>';
} else {
    foreach ($assignments as $assignment) {
        $percentage = $assignment->rawgrademax ? round(($assignment->finalgrade / $assignment->rawgrademax) * 100) : 0;
        
        echo '
        <div class="accordion-item">
            <div class="accordion-header">
                <span>' . format_string($assignment->itemname) . '</span>
                <div class="exam-meta">
                    <span class="score">' . $assignment->finalgrade . '/' . $assignment->rawgrademax . '</span>
                    <span class="percentage">' . $percentage . '%</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="accordion-content">
                <div class="result-details">
                    <div class="detail-row">
                        <span>' . get_string('course') . ':</span>
                        <span>' . format_string($assignment->coursename) . '</span>
                    </div>
                    <div class="detail-row">
                        <span>' . get_string('maxmarks', 'grades') . ':</span>
                        <span>' . $assignment->rawgrademax . '</span>
                    </div>
                    <div class="detail-row">
                        <span>' . get_string('obtained', 'grades') . ':</span>
                        <span>' . $assignment->finalgrade . '</span>
                    </div>
                    <div class="detail-row">
                        <span>' . get_string('percentage', 'grades') . ':</span>
                        <span>' . $percentage . '%</span>
                    </div>
                    <div class="detail-row">
                        <span>' . get_string('gradedon', 'grades') . ':</span>
                        <span>' . $assignment->gradeddate . '</span>
                    </div>
                </div>
                <div class="result-chart">
                    <div class="chart-bar" style="width: ' . $percentage . '%;"></div>
                </div>
                ' . (!empty($assignment->feedback) ? '<div class="feedback"><strong>' . get_string('feedback', 'assign') . ':</strong> ' . format_text($assignment->feedback) . '</div>' : '') . '
            </div>
        </div>';
    }
}
?>