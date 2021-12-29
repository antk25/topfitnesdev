 #!/bin/bash

rsync -avzhe ssh --progress public/css topfitnesbraslet@46.101.120.173:~/public_html/current/public/css
rsync -avzhe ssh --progress public/js topfitnesbraslet@46.101.120.173:~/public_html/current/public/js
rsync -avzhe ssh --progress public/img topfitnesbraslet@46.101.120.173:~/public_html/current/public/img
