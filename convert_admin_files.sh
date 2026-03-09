#!/bin/bash

# Daftar file yang perlu diubah
files=(
    "bimbingan-konseling.blade.php"
    "data-jenis-pelanggaran.blade.php"
    "data-jenis-prestasi.blade.php"
    "data-pelanggaran.blade.php"
    "data-prestasi.blade.php"
    "data-sanksi.blade.php"
    "data-verifikasi.blade.php"
    "jenis_sanksi.blade.php"
    "manajemen-user.blade.php"
    "monitoring-pelanggaran.blade.php"
    "tahun-ajaran.blade.php"
)

for file in "${files[@]}"; do
    filepath="/Users/labsa.smkbn666.pk08/Documents/WebsideKesiswaanSurya/resources/views/page_admin/$file"
    
    if [ -f "$filepath" ]; then
        echo "Converting $file..."
        
        # Backup original file
        cp "$filepath" "${filepath}.backup"
        
        # Get the title from filename
        title=$(echo "$file" | sed 's/.blade.php//' | sed 's/-/ /g' | sed 's/\b\w/\U&/g')
        
        # Create temporary file with new structure
        cat > "${filepath}.tmp" << EOF
@extends('layouts.admin')

@section('title', '$title')
@section('page-title', '$title')

@section('content')
EOF
        
        # Extract content between <div class="p-4"> and </div></div> (main content)
        sed -n '/<div class="p-4">/,/<\/body>/p' "$filepath" | sed '1d;$d' | sed '$d' | sed '$d' | sed '$d' | sed '$d' >> "${filepath}.tmp"
        
        echo "@endsection" >> "${filepath}.tmp"
        
        # Extract JavaScript if exists
        if grep -q "<script>" "$filepath"; then
            echo "" >> "${filepath}.tmp"
            echo "@section('scripts')" >> "${filepath}.tmp"
            sed -n '/<script>/,/<\/script>/p' "$filepath" | grep -v "bootstrap.bundle.min.js" >> "${filepath}.tmp"
            echo "@endsection" >> "${filepath}.tmp"
        fi
        
        # Replace original file
        mv "${filepath}.tmp" "$filepath"
        
        echo "Converted $file successfully"
    else
        echo "File $file not found"
    fi
done

echo "All files converted!"