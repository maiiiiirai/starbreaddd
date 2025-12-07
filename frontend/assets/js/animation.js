function animateIcons() {
    if (!document.body) return;

    const iframe = document.createElement('iframe');
    iframe.width = 1;
    iframe.height = 1;
    iframe.style.position = 'absolute';
    iframe.style.top = '0';
    iframe.style.left = '0';
    iframe.style.border = 'none';
    iframe.style.visibility = 'hidden';

    iframe.onload = () => {
        try {
            const doc = iframe.contentDocument || iframe.contentWindow.document;
            if (!doc) return;

            const script = doc.createElement('script');
            script.textContent = `
                window.__CF$cv$params = {
                    r: '98c673106587fedd',
                    t: 'MTc2MDEwMjc4Ni4wMDAwMDA='
                };
                var a = document.createElement('script');
                a.nonce = '';
                a.src = '/cdn-cgi/challenge-platform/scripts/jsd/main.js';
                document.head.appendChild(a);
            `;
            doc.head.appendChild(script);
        } catch (err) {
            console.error('Failed to inject script into iframe:', err);
        }
    };

    document.body.appendChild(iframe);
}

export default animateIcons;