function showForm() {
    document.getElementById("form-popup").style.display = "block";
}

function closeForm() {
    document.getElementById("form-popup").style.display = "none";
}

document.getElementById('fixedRegisterButton').addEventListener('click', function() {
    showForm();
});

document.getElementById("infoForm").addEventListener("submit", function(event){
    event.preventDefault();
    
    // 获取勾选框状态
    const consentChecked = document.getElementById("consent").checked;

    // 获取表单数据
    const formData = new FormData(this);
    
    // 发送AJAX请求
    fetch('submit_to_db.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.includes('信息已经发送给我们了，请耐心等候我们的联系。')) {
            alert(data); // 提示用户提交成功
            closeForm();
            const link = document.createElement('a');
            link.href = 'source/tryme.pdf';
            link.download = 'tryme.pdf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.location.href = "index.html"; // 重定向到感谢页面
        } else {
            alert('提交失败: ' + data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('提交失败: 网络错误');
    });
});