 #!/bin/bash

rsync -avzhe ssh --progress public/css topfitnesbraslet@62.113.100.14:~/public_html/current/public/css
rsync -avzhe ssh --progress public/js topfitnesbraslet@62.113.100.14:~/public_html/current/public/js
rsync -avzhe ssh --progress public/img topfitnesbraslet@62.113.100.14:~/public_html/current/public/img
