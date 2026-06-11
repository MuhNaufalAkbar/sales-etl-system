/* ============================================================
   Sales ETL System — Upload Page Scripts
   ============================================================ */

const dropzone   = document.getElementById('dz');
const fileInput  = document.getElementById('fileInput');
const fileNameText = document.getElementById('fn_file');
const fileList   = document.getElementById('fileList');

function updateSubmitBtn() {
    const count = fileInput.files.length;
    document.getElementById('btnUpload').disabled = count !== 3;
    return count;
}

function renderFileList(files) {
    fileList.innerHTML = '';
    Array.from(files).forEach(file => {
        const li = document.createElement('li');
        li.textContent = file.name;
        fileList.appendChild(li);
    });
}

function markFilled(files) {
    const count = files.length;
    dropzone.classList.add('filled');
    fileNameText.textContent = count === 3
        ? '✓ 3 file siap diupload'
        : `✓ ${count} file dipilih`;
    renderFileList(files);
}

function handleFiles(files) {
    const accepted = Array.from(files).filter(file => {
        const ext = file.name.split('.').pop().toLowerCase();
        return ['xlsx', 'xls', 'csv'].includes(ext);
    });

    if (!accepted.length) return;

    const dt = new DataTransfer();
    accepted.slice(0, 3).forEach(file => dt.items.add(file));
    fileInput.files = dt.files;
    markFilled(fileInput.files);
    updateSubmitBtn();
}

fileInput.addEventListener('change', () => {
    if (fileInput.files.length) markFilled(fileInput.files);
    updateSubmitBtn();
});

dropzone.addEventListener('dragover', e => {
    e.preventDefault();
    dropzone.classList.add('dragover');
});

dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('dragover');
});

dropzone.addEventListener('drop', e => {
    e.preventDefault();
    dropzone.classList.remove('dragover');
    handleFiles(e.dataTransfer.files);
});

document.getElementById('uploadForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form    = this;
    const btn     = document.getElementById('btnUpload');
    const btnText = document.getElementById('btnText');
    const bar     = document.getElementById('progressBar');
    const text    = document.getElementById('progressText');

    btn.disabled = true;
    btnText.innerText = 'Mengupload...';

    let progress = 0;

    const interval = setInterval(() => {
        progress += Math.floor(Math.random() * 8) + 2;

        if (progress >= 95) {
            progress = 95;
            clearInterval(interval);

            btnText.innerText = 'Memproses Data ETL...';

            setTimeout(() => {
                bar.style.width = '100%';
                text.innerText  = '100%';
                btnText.innerText = 'Membuka Dashboard...';

                setTimeout(() => form.submit(), 1000);
            }, 2000);
        }

        bar.style.width = progress + '%';
        text.innerText  = progress + '%';
    }, 300);
});