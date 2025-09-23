<div class="container-fluid mt-3">
    <div class="row g-3">
        <!-- Feedback Given By Student -->
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Feedback Given By Student</h2>
                    <div class="tabs">
                        <button class="tab-btn active" data-target="given-teacher">To Teacher</button>
                        <button class="tab-btn" data-target="given-group">To Group</button>
                    </div>
                </div>
                <div class="feedback-list">
                    <?php
                    // Safely initialize if null
                    $feedback_given = $feedback_given ?? [];
                    ?>
                    
                    <!-- Teacher Feedback -->
                    <div class="feedback-tab-content active" id="given-teacher">
                        <?php
                        $teacher_feedback = array_filter($feedback_given, function($fb) {
                            return is_object($fb) && property_exists($fb, 'recipienttype') && $fb->recipienttype === 'teacher';
                        });
                        
                        if (!empty($teacher_feedback)): 
                            foreach ($teacher_feedback as $feedback): ?>
                                <div class="feedback-item">
                                    <p class="feedback-text"><?php echo format_text($feedback->feedbacktext ?? ''); ?></p>
                                    <div class="feedback-meta">
                                        <span><?php echo !empty($feedback->timecreated) ? userdate($feedback->timecreated, '%B %d, %Y') : ''; ?></span>
                                        <span class="dot"></span>
                                        <span>To <a href="<?php echo $feedback->recipientlink ?? '#'; ?>"><?php echo $feedback->recipientname ?? 'Unknown'; ?></a></span>
                                    </div>
                                </div>
                            <?php endforeach;
                        else: ?>
                            <div class="feedback-item">
                                <p class="feedback-text">No feedback given to teachers yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Group Feedback -->
                    <div class="feedback-tab-content" id="given-group">
                        <?php
                        $group_feedback = array_filter($feedback_given, function($fb) {
                            return is_object($fb) && property_exists($fb, 'recipienttype') && $fb->recipienttype === 'group';
                        });
                        
                        if (!empty($group_feedback)):
                            foreach ($group_feedback as $feedback): ?>
                                <div class="feedback-item">
                                    <p class="feedback-text"><?php echo format_text($feedback->feedbacktext ?? ''); ?></p>
                                    <div class="feedback-meta">
                                        <span><?php echo !empty($feedback->timecreated) ? userdate($feedback->timecreated, '%B %d, %Y') : ''; ?></span>
                                        <span class="dot"></span>
                                        <span>To Group: <a href="<?php echo $feedback->recipientlink ?? '#'; ?>"><?php echo $feedback->recipientname ?? 'Unknown'; ?></a></span>
                                    </div>
                                </div>
                            <?php endforeach;
                        else: ?>
                            <div class="feedback-item">
                                <p class="feedback-text">No feedback given to groups yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Feedback Given To Student -->
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Feedback Given To Student</h2>
                    <div class="tabs">
                        <button class="tab-btn active" data-target="received-teacher">By Teacher</button>
                        <button class="tab-btn" data-target="received-management">By Management</button>
                    </div>
                </div>
                <div class="feedback-list">
                    <?php
                    // Safely initialize if null
                    $feedback_received = $feedback_received ?? [];
                    ?>
                    
                    <!-- Teacher Feedback -->
                    <div class="feedback-tab-content active" id="received-teacher">
                        <?php
                        $teacher_received = array_filter($feedback_received, function($fb) {
                            return is_object($fb) && property_exists($fb, 'authortype') && $fb->authortype === 'teacher';
                        });
                        
                        if (!empty($teacher_received)):
                            foreach ($teacher_received as $feedback): ?>
                                <div class="feedback-item">
                                    <p class="feedback-text"><?php echo format_text($feedback->feedbacktext ?? ''); ?></p>
                                    <div class="feedback-meta">
                                        <span><?php echo !empty($feedback->timecreated) ? userdate($feedback->timecreated, '%B %d, %Y') : ''; ?></span>
                                        <span class="dot"></span>
                                        <span>By <a href="<?php echo $feedback->authorlink ?? '#'; ?>"><?php echo $feedback->authorname ?? 'Unknown'; ?></a></span>
                                    </div>
                                </div>
                            <?php endforeach;
                        else: ?>
                            <div class="feedback-item">
                                <p class="feedback-text">No feedback received from teachers yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Management Feedback -->
                    <div class="feedback-tab-content" id="received-management">
                        <?php
                        $management_received = array_filter($feedback_received, function($fb) {
                            return is_object($fb) && property_exists($fb, 'authortype') && $fb->authortype === 'management';
                        });
                        
                        if (!empty($management_received)):
                            foreach ($management_received as $feedback): ?>
                                <div class="feedback-item">
                                    <p class="feedback-text"><?php echo format_text($feedback->feedbacktext ?? ''); ?></p>
                                    <div class="feedback-meta">
                                        <span><?php echo !empty($feedback->timecreated) ? userdate($feedback->timecreated, '%B %d, %Y') : ''; ?></span>
                                        <span class="dot"></span>
                                        <span>By Management: <a href="<?php echo $feedback->authorlink ?? '#'; ?>"><?php echo $feedback->authorname ?? 'Unknown'; ?></a></span>
                                    </div>
                                </div>
                            <?php endforeach;
                        else: ?>
                            <div class="feedback-item">
                                <p class="feedback-text">No feedback received from management yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
