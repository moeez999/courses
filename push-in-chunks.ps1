# Get all changed (tracked + untracked) files
$files = git status --porcelain | ForEach-Object {
    ($_ -split '\s+', 3)[2]
}

if (-not $files) {
    Write-Host "No changes to push."
    exit
}

# Group files into batches of 10
$chunks = [System.Collections.ArrayList]@()
for ($i = 0; $i -lt $files.Count; $i += 10) {
    $end = [Math]::Min($i+9, $files.Count-1)
    $chunks.Add($files[$i..$end])
}

# Process each batch
$batchNumber = 1
foreach ($chunk in $chunks) {
    Write-Host "Processing batch $batchNumber with $($chunk.Count) files..."

    git add -- $chunk
    git commit -m "Batch commit $batchNumber"
    git push origin main

    $batchNumber++
}

Write-Host "All batches pushed successfully."
