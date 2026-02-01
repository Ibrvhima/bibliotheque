<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Pagination Styles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom pagination styles for better mobile experience */
        .pagination-container {
            @apply flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0;
        }
        
        .pagination-info {
            @apply text-sm text-gray-700 text-center sm:text-left;
        }
        
        .pagination-links {
            @apply flex items-center justify-center space-x-1 sm:space-x-2;
        }
        
        .pagination-link {
            @apply px-3 py-2 sm:px-4 sm:py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 min-w-[44px] sm:min-w-[48px];
        }
        
        .pagination-link.active {
            @apply z-10 bg-blue-50 border-blue-500 text-blue-600;
        }
        
        .pagination-link.disabled {
            @apply opacity-50 cursor-not-allowed;
        }
        
        .pagination-link.mobile-only {
            @apply sm:hidden;
        }
        
        .pagination-link.desktop-only {
            @apply hidden sm:inline-flex;
        }
    </style>
</head>
<body>
    <!-- Example usage -->
    <div class="pagination-container">
        <div class="pagination-info">
            Affichage de <span class="font-medium">1</span> à 
            <span class="font-medium">10</span> sur 
            <span class="font-medium">100</span> résultats
        </div>
        
        <div class="pagination-links">
            <!-- Previous -->
            <a href="#" class="pagination-link disabled">
                <i class="fas fa-chevron-left"></i>
                <span class="hidden sm:inline ml-2">Précédent</span>
            </a>
            
            <!-- Page numbers -->
            <a href="#" class="pagination-link active">1</a>
            <a href="#" class="pagination-link">2</a>
            <a href="#" class="pagination-link">3</a>
            <span class="pagination-link">...</span>
            <a href="#" class="pagination-link">10</a>
            
            <!-- Next -->
            <a href="#" class="pagination-link">
                <span class="hidden sm:inline mr-2">Suivant</span>
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>
</body>
</html>
