/**
 * Parse API responses that may be prefixed with PHP warnings (Laragon/Windows).
 */
window.RedragonJson = {
    parse: function (xhrOrText) {
        var text = '';
        if (typeof xhrOrText === 'string') {
            text = xhrOrText;
        } else if (xhrOrText && xhrOrText.responseText) {
            text = xhrOrText.responseText;
        } else if (xhrOrText && xhrOrText.responseJSON) {
            return xhrOrText.responseJSON;
        }
        if (!text) {
            return null;
        }
        var start = text.indexOf('{');
        var arrStart = text.indexOf('[');
        if (arrStart >= 0 && (start < 0 || arrStart < start)) {
            start = arrStart;
        }
        if (start < 0) {
            return null;
        }
        try {
            return JSON.parse(text.substring(start));
        } catch (e) {
            return null;
        }
    },

    showAlert: function ($box, type, message) {
        if (!$box || !$box.length) {
            return;
        }
        var cls = type === 'success' ? 'alert-success' : (type === 'info' ? 'alert-info' : 'alert-danger');
        $box.removeClass('d-none alert-success alert-danger alert-info')
            .addClass(cls)
            .html(message || '')
            .show();
    },

    hideAlert: function ($box) {
        if ($box && $box.length) {
            $box.addClass('d-none').hide().html('');
        }
    }
};
