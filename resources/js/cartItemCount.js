function getCsrfToken() {
    const m = document.head.querySelector('meta[name="csrf-token"]');
    return m ? m.content : '';
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form.ajax-add-to-cart').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json'
                    },
                    body: formData,
                    credentials: 'same-origin',
                });

                const json = await res.json();

                window.dispatchEvent(new CustomEvent('cart-updated', { detail: json.cartCount ?? 0 }));

            } catch (err) {
                console.error('Add to cart failed', err);
                form.submit();
            }
        });
    });
});