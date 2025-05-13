document.querySelectorAll(".auto-ajustable").forEach(textarea => {
    textarea.addEventListener("input", function () {
        this.style.height = "auto";
        this.style.height = this.scrollHeight + "px";
    });
    textarea.dispatchEvent(new Event('input'));
});