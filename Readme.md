
# Motrolix typegrid child theme v1.1.1

- Updated render blocking write methods in header.php
- Updated deprecated functions and syntax
- Installed and tweaked Auto Optimize for an overall speed boost of 20-30%
- Fixed header ads bottom margin so borders no longer collide
- Fixed last ad in content area being off center from the main column of ads
- Fixed Twitter button alignment in footer
- Added margin to login/logout button
- Fixed multiple bugs resulting from optimization
- Centered bottom nav bar
- Added responsive media queries for style fixes supporting multiple screen sizes
- Completed making staging site a very close mirror of production site
- Added notes to fix wp super cache conflict

## Notes

- Install the plugin Auto Optimize and check the boxes under JavaScript Options to: Optimize JavaScript Code.
- The Javascript Exclude scripts from Autooptimize should read as follows: wp-includes/js/dist/, wp-includes/js/tinymce/, js/jquery/jquery.js, js/jquery/jquery.min.js, /font/ 
- Under CSS Options check boxes to: Optimize CSS Code.
- The CSS Exclude scripts from Auto optimize should read as follows: wp-content/cache/, wp-content/uploads/, admin-bar.min.css, dashicons.min.css, /font/
- Under Misc Options all 4 options should be selected
- Site speed should now be increased by an average of 20%
- Because of a conflict with cache location sharing the following line below needs to be added to wp-config.php 
- define( 'AUTOPTIMIZE_CACHE_CHILD_DIR', '/resources/' );
- Make sure no aggregating options are checked