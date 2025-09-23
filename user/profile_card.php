<div class="mdl-profilecard">
    <div class="mdl-profilecard-left">
        <div class="mdl-profilecard-avatar">
            <?php echo $OUTPUT->user_picture($user, ['size' => 48]); ?>
        </div>
        <div class="mdl-profilecard-name">
            <?php echo fullname($user); ?>
        </div>
    </div>
    <a href="<?php echo $CFG->wwwroot . '/user/edit.php?id=' . $user->id; ?>">
        <button class="mdl-profilecard-editbtn" title="Edit Profile">
            <svg xmlns="http://www.w3.org/2000/svg" height="22" width="22" viewBox="0 0 24 24" fill="currentColor">
                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41
                l-2.34-2.34a.9959.9959 0 0 0-1.41 0L15.13 4.7l3.75 3.75 1.83-1.41z"/>
            </svg>
        </button>
    </a>
</div>