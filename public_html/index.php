<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Email- Mateusz Janicki 3P1b</title>
    <script>
        const getFiles = () => {
            let files = document.getElementById("file");

            const filesFiles = files.files
            let newFilesFiles = []

            for (var i = 0; i < filesFiles.length; ++i) {
                // console.log('filesFiles', filesFiles[i].name, filesFiles[i].size)
                if(filesFiles[i].size < 25000000){
                    if(!newFilesFiles.includes(filesFiles[i])){
                        newFilesFiles.push(filesFiles[i])
                    }
                }else{
                    console.log(filesFiles[i].name + ' jest za duzy ')
                    let c = filesFiles[i].name + ' jest za duzy '
                    const textt = document.createTextNode(c)
                    document.getElementById('sub').disabled = true

                    let myDiv = document.getElementById('none')
                    myDiv.style.display = "none"
                    myDiv.innerHTML = 'now'
                    myDiv.style.color = 'red'
                    document.getElementById("image").appendChild(textt)
                }
            }
            console.log('new',newFilesFiles)
    
            var m = document.querySelector('#file').value

            console.log(m)

            newFilesFiles.forEach((e)=> {
                const img = document.createElement('img')
                img.src = './upload/x.png'
                img.style.height = '30px'
                img.style.width = '30px'
                img.className = 'imgg'
                img.onclick = function(){ 
                    alert("Niestety nie da sie usunac pliku" + e.name)

                }
                const text = document.createElement("a")
                let b = JSON.stringify(e.name)
                const textnode = document.createTextNode(b)
                textnode.class = 'textt'
                text.appendChild(textnode)
                text.appendChild(img)
                document.getElementById("image").appendChild(text)
            })

            // for(var a = 0; a < newFilesFiles.length; a++){
            //     const img = document.createElement('img')
            //     img.src = './upload/x.png'
            //     img.style.height = '30px'
            //     img.style.width = '30px'
            //     img.className = 'imgg'
            //     img.onclick = function(){ alert(a)}
            //     const text = document.createElement("a")
            //     let b = JSON.stringify(newFilesFiles[a].name)
            //     const textnode = document.createTextNode(b)
            //     textnode.class = 'textt'
            //     text.appendChild(textnode)
            //     text.appendChild(img)
            //     document.getElementById("image").appendChild(text)
            // }
        }
        function send(e){
            e.preventDefault()
            if(document.getElementById('none').style.display == "none"){
                window.location = 'http://mateuszjanicki.tk'
            }else{
                let files = document.getElementById("file");
                // console.log(files.files);

                for (var i = 0; i < files.files.length; ++i) {
                    var name = files.files.item(i).name;
                    console.log("here is a file name: " + name);
                }

                const allowedSize = 25000000

                
                // pozostałe można skolejkować - poniżej upload pierwszego pliku

                let data = new FormData();


                let formDate = document.getElementById('date').value
                let formTime = document.getElementById('time').value
                let formTo = document.getElementById('to').value
                let formTitle = document.getElementById('title').value
                let formTextarea = document.getElementById('textarea').value
                let formPass = document.getElementById('pass').value

                Object.size = function(obj) {
                var size = 0,
                    key;
                for (key in obj) {
                    if (obj.hasOwnProperty(key)) size++;
                }
                return size;
                };

                // Get the size of an object
                var size = Object.size(files.files)

                if(size > 1){
                    // for (var m = 0; m < files.files.length; m++) {
                    for (var m = 0; m < size; m++) {
                        let toSend = files.files[m]
                        data.append("files[]", toSend);

                        data.append("date", formDate)
                        data.append("time", formTime)
                        data.append("to", formTo)
                        data.append("title", formTitle)
                        data.append("message", formTextarea)
                        data.append("pass", formPass)
                    }
                }else{
                    if(size == 1){
                    // if(files.files.lenght == 1){
                        let toSend = files.files[0]
                        data.append("files[]", toSend);

                        data.append("date", formDate)
                        data.append("time", formTime)
                        data.append("to", formTo)
                        data.append("title", formTitle)
                        data.append("message", formTextarea)
                        data.append("pass", formPass)
                    }else{
                        data.append("date", formDate)
                        data.append("time", formTime)
                        data.append("to", formTo)
                        data.append("title", formTitle)
                        data.append("message", formTextarea)
                        data.append("pass", formPass)
                    }
                }

                const request = new XMLHttpRequest();
                request.open("POST", "./upload.php");

                request.upload.addEventListener('progress', function(e) {
                    let complete = (e.loaded / e.total) * 100;
                    console.log("progress: ", complete);
                    document.getElementById('divvis').style.display = 'block'
                    document.getElementById('progress').value = complete
                });

                request.addEventListener('load', function(e) {
                    console.log(request.status);
                    console.log(request.response);
                });
                request.send(data);

                // while(finalArr.length > 0){
                //     finalArr.shift()
                // }
                document.querySelector('#file').value = ''
                document.getElementById('image').innerHTML = ""
                document.getElementById('divvis').style.display = 'none'
                // location.reload()
            }
        }
    </script>
</head>
<body class="cont">
    <div class="cont1">
        <a href="https://drive.google.com/file/d/1ydZjJnCywEWr_JgwgE1e6f1YTc7wlAGs/view?usp=sharing">hrefff</a>
        <form method="post" action="./upload.php" enctype="multipart/form-data">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" class="i0"><br><br>
            <label for="time">Time:</label>
            <input type="time" id="time" name="time" class="i00"><br><br>
            <label for="to">To:</label>
            <input type="email" id="to" name="to" class="i2" size="50" placeholder="Enter receiver e-mail"><br><br>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="i3" size="50" placeholder="Enter the title"><br><br>
            <div class="cont3">
                <label for="textarea" class="lTA">Message:</label>
                <textarea id="textarea" name="textarea" class="textarea" rows="20" cols="50" placeholder="Enter the message"></textarea>
            </div>
            <label for="pass">Pass:</label>
            <input style="margin-top: 20px" type="password" id="pass" name="pass" class="i0" size="50" placeholder="Enter your password"><br><br>
            <input type="file" id="file" name="files[]" class="file" onchange="{getFiles(), console.log(this.files)}" multiple accept="image/jpeg, image/png">
            <input id="sub" type="submit" name="submit" value="Send" class="butek" onclick="send(event)">
        </form>
        <div id="image" class="divv"></div>
        <a id="none"></a>
        <br/><br/>
        <div id="divvis" style="display: none">
            <label>Sending:</label>
            <progress id="progress" style="width: 380px, margin-left: 10px" max="100" value="0"></progress>
        </div>
    </div>
</body>
</html>