        const xhr = new XMLHttpRequest(); //khai báo để thực hiện suy cập vào 1 file khác hay 1 web khác bằng js
        xhr.open('GET', 'json/tinh_tp.json');
        xhr.responseType = 'json';//kiểu trả về
        xhr.onload = function (e) {
            if (this.status == 200) {//kiểm tra có bị lỗi hay hông (200 là hông lỗi)
                var newContent = '';
                for (var i in this.response) {
                    // console.log(this.response[a[i]].name);
                    newContent += '<option class="event" value="';
                    newContent += this.response[i].code;
                    newContent += '">';
                    newContent += this.response[i].name_with_type;
                    newContent += '</option>';
                }
                document.getElementById('tinh').innerHTML += newContent;
            }
        };
        xhr.send();

        document.getElementById('tinh').onchange = function () {
            if (this.value != "0000") {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'json/quan-huyen/' + this.value + '.json');
                xhr.responseType = 'json';
                xhr.onload = function (e) {
                    if (this.status == 200) {
                        var newContent = '';
                        for (var i in this.response) {
                            newContent += '<option class="event" value="';
                            newContent += this.response[i].code;
                            newContent += '">';
                            newContent += this.response[i].name_with_type;
                            newContent += '</option>';
                        }
                        document.getElementById('huyen').innerHTML = newContent;
                    }
                };
                xhr.send();
            }
        }
        document.getElementById('huyen').onchange = function () {
            if (this.value != "0000") {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'json/xa-phuong/' + this.value + '.json');
                xhr.responseType = 'json';
                xhr.onload = function (e) {
                    if (this.status == 200) {
                        var newContent = '';
                        for (var i in this.response) {
                            newContent += '<option class="event" value="';
                            newContent += this.response[i].path_with_type;
                            newContent += '">';
                            newContent += this.response[i].name_with_type;
                            newContent += '</option>';
                        }
                        document.getElementById('xa').innerHTML = newContent;
                    }
                };
                xhr.send();
            }
        }