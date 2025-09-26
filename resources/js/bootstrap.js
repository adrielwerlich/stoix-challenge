import axios from "axios";

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;

    window.axios.defaults.headers.post["X-CSRF-TOKEN"] = token.content;
    window.axios.defaults.headers.put["X-CSRF-TOKEN"] = token.content;
    window.axios.defaults.headers.patch["X-CSRF-TOKEN"] = token.content;
    window.axios.defaults.headers.delete["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}
