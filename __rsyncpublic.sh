 #!/bin/bash

# rsync -avzhe ssh --progress public/css topfitnesbraslet@62.113.100.14:~/public_html/current/public/css
# rsync -avzhe ssh --progress public/js topfitnesbraslet@62.113.100.14:~/public_html/current/public/js
rsync -avzhe ssh --progress topfitnesbraslet@62.113.100.14:~/public_html/current/public/img public/img
rsync -avzhe ssh --progress topfitnesbraslet@62.113.100.14:~/public_html/current/public/storage public/storage
