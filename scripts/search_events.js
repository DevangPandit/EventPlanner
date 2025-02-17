document.addEventListener("DOMContentLoaded", () => {
    const searchForm = document.getElementById("searchForm");
    const searchInput = document.getElementById("searchInput");

    // Add event listener to the search form
    searchForm.addEventListener("submit", (event) => {
        const query = searchInput.value.trim();
        if (!query) {
            event.preventDefault(); // Prevent form submission if input is empty
            alert("Please enter a search term.");
        }
    });

    // Example of additional functionality (e.g., auto-clear input on double-click)
    searchInput.addEventListener("dblclick", () => {
        searchInput.value = "";
    });
});
