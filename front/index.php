<?php
  session_start();
  include('../api/functions.php');
  check_session_id();
  echo "<p>user_id:{$_SESSION['user_id']}</p>";
  echo '<a href="../api/logout.php">logout</a>';
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>php_db_api</title>
  <link rel="stylesheet" href="css/main.css">
</head>


<body>
  <button id="getSession">getSession</button>
  <h1>todo管理アプリ</h1>
  <fieldset>
    <legend>insert form</legend>
    <form>
      <div>
        <label for="task">task</label>
        <input type="text" id="task">
      </div>
      <div>
        <label for="deadline">deadline</label>
        <input type="date" id="deadline">
      </div>
      <div>
        <label for="comment">comment</label>
        <textarea name="" id="comment" cols="30" rows="10"></textarea>
      </div>
      <div>
        <label for="image">image</label>
        <input type="file" id="image" accept="image/*">
      </div>
      <button type="button" id="send">send</button>
    </form>
  </fieldset>

  <fieldset>
    <legend>search form</legend>
    <form>
      <div>
        <label for="search">search</label>
        <input type="text" id="search">
      </div>
    </form>
  </fieldset>

  <fieldset>
    <legend>data table</legend>
    <table>
      <thead>
        <tr>
          <th></th>
          <th>id</th>
          <th>task</th>
          <th>deadline</th>
          <th>comment</th>
          <th>image</th>
          <th>created_at</th>
          <th>updated_at</th>
        </tr>
      </thead>
      <tbody id="echo"></tbody>
    </table>
  </fieldset>

  <div id="modal" class="modal">
    <div class="modal-content">
      <fieldset>
        <legend>edit form</legend>
        <form>
          <div>
            <label for="taskEdit">task</label>
            <input type="text" id="taskEdit">
          </div>
          <div>
            <label for="deadlineEdit">deadline</label>
            <input type="date" id="deadlineEdit">
          </div>
          <div>
            <label for="commentEdit">comment</label>
            <textarea name="" id="commentEdit" cols="30" rows="10"></textarea>
          </div>
          <input type="hidden" name="" id="hiddenId">
          <button type="button" id="updateButton">update</button>
        </form>
      </fieldset>
    </div>
  </div>




  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

  <script>
    // モーダルの黒い部分クリックで閉じる処理
    document.getElementById('modal').addEventListener('click', e => {
      // モーダルのフォームクリック時には閉じないように条件を分ける
      if (e.target == document.getElementById('modal')) {
        document.getElementById('modal').style.display = 'none';
      }
    });

    const createUrl = '../api/create.php';
    const readUrl = '../api/read.php';
    // ↓テスト用
    // const readUrl = '../api/test.json';

    // 配列をタグに入れていい感じの形にする関数
    const convertArraytoListTag = array => {
      return array.map(x => {
        return `<tr>
                  <td>
                    <button type="button" class="editButton" value=${x.id}>edit</button>
                    <button type="button" class="deleteButton" value=${x.id}>delete</button>
                  </td>
                  <td>${x.id}</td>
                  <td>${x.task}</td>
                  <td>${x.deadline}</td>
                  <td>${x.comment}</td>
                  <td>
                    <img src="../api/${x.image}" height="50px" onerror='this.style.display = "none"'>
                  </td>
                  <td>${x.created_at}</td>
                  <td>${x.updated_at}</td>
                </tr>`;
      }).join('');
    }

    // readの処理をする関数を定義
    // 読み込み時とデータ登録時の両方で実行したいため
    const readData = url => {
      axios.get(url)
        .then(response => {
          // 成功した時
          console.log(response);
          // テーブルタグの中身を生成して表示
          document.getElementById('echo').innerHTML = convertArraytoListTag(response.data);
          // 更新ボタンクリック時の処理
          // 該当するidのデータを取得してフォームのvalueに設定する
          // データ取得後（DOM生成後）でないとクリックイベントを追加できない
          document.querySelectorAll('.editButton').forEach(x => {
            x.addEventListener('click', e => {
              const id = e.target.value;
              const requestUrl = `../api/edit.php?id=${id}`;
              axios.get(requestUrl)
                .then(response => {
                  console.log(response.data);
                  // updateフォームに値を設定
                  document.getElementById('taskEdit').value = response.data.task;
                  document.getElementById('deadlineEdit').value = response.data.deadline;
                  document.getElementById('commentEdit').value = response.data.comment;
                  document.getElementById('hiddenId').value = response.data.id;
                })
                .catch(error => {
                  // 失敗した時
                  console.log(error);
                  alert(error);
                })
                .finally(() => {
                  // 成功失敗どちらでも実行
                });;
              // モーダルの表示
              document.getElementById('modal').style.display = 'block';
            });
          });
          // 削除ボタンクリック時の処理
          // phpにデータを送信してdbのデータを削除してもらう
          document.querySelectorAll('.deleteButton').forEach(x => {
            x.addEventListener('click', e => {
              if (window.confirm('Are you sure?')) {
                const id = e.target.value;
                const requestUrl = `../api/delete.php?id=${id}`;
                axios.delete(requestUrl)
                  .then(response => {
                    console.log(response.data);
                    alert('deleted!');
                    // 最新のデータを取得
                    readData(readUrl);
                  })
                  .catch(error => {
                    // 失敗した時
                    console.log(error);
                    alert(error);
                  })
                  .finally(() => {
                    // 成功失敗どちらでも実行
                  });;
              }
            });
          });
          return response;
        })
        .catch(error => {
          // 失敗した時
          console.log(error);
          alert(error);
        })
        .finally(() => {
          // 成功失敗どちらでも実行
        });
    }

    // 送信ボタンクリック時の処理
    document.getElementById('send').addEventListener('click', () => {
      // createの処理
      // formのキーとバリューを入れる容器を準備する
      const postData = new FormData();
      // postDataに必要なパラメータを追加する
      postData.append('task', document.getElementById('task').value);
      postData.append('deadline', document.getElementById('deadline').value);
      postData.append('comment', document.getElementById('comment').value);
      postData.append('upfile', document.getElementById('image').files[0]);
      console.log(...postData.entries());
      // 送信先urlの指定
      const fileUpLoadUrl = '../api/upload.php'
      // 送信の処理
      axios.post(fileUpLoadUrl, postData)
        .then(response => {
          // 成功した時
          console.log(response);
          readData(readUrl);
          // 入力欄を空にする処理
          document.getElementById('task').value = '';
          document.getElementById('deadline').value = '';
          document.getElementById('comment').value = '';
          document.getElementById('image').value = '';
        })
        .catch(error => {
          // 失敗した時
          console.log(error);
          alert(error);
        })
        .finally(() => {
          // 成功失敗どちらでも実行
        });
    });

    // アップデートフォームのupdateボタンクリック時の処理
    // phpにデータを送信してdbのデータを更新してもらう
    document.getElementById('updateButton').addEventListener('click', e => {
      // 更新したいレコードのidを取得
      const updateId = document.getElementById('hiddenId').value;
      // formのキーとバリューを入れる容器を準備する
      const updateData = new FormData();
      // dataに必要なパラメータを追加する
      updateData.append('task', document.getElementById('taskEdit').value);
      updateData.append('deadline', document.getElementById('deadlineEdit').value);
      updateData.append('comment', document.getElementById('commentEdit').value);
      console.log(...updateData.entries());
      // PUTメソッドの設定
      const config = {
        headers: {
          'X-HTTP-Method-Override': 'PUT',
        }
      }
      // 送信先の指定
      const requestUrl = `../api/update.php?id=${updateId}`;
      // 送信の処理
      axios.post(requestUrl, updateData, config)
        .then(response => {
          alert('updated!');
          // モーダルを閉じる
          document.getElementById('modal').style.display = 'none';
          // 最新のデータを取得
          readData(readUrl);
        })
        .catch(error => {
          // 失敗した時
          console.log(error);
          alert(error);
        })
        .finally(() => {
          // 成功失敗どちらでも実行
        });
    });

    // 検索ボックスに入力時の処理
    document.getElementById('search').addEventListener('keyup', e => {
      // inputの値を取得
      const searchWord = e.target.value;
      // ?の後にパラメータを指定して値を送信できる
      const requestUrl = `../api/search.php?searchWord=${searchWord}`;
      readData(requestUrl);
    });

    // カラム名クリック時の並び替え処理
    // thタグ全てにクリックイベントを設定
    document.querySelectorAll('th').forEach(x => {
      x.addEventListener('click', e => {
        // thタグのテキストを取得
        const columnName = e.target.innerText;
        // urlに入れて送信
        const requestUrl = `../api/sort.php?columnName=${columnName}`;
        readData(requestUrl);
      });
    });

    // 読み込み時のデータ取得処理
    window.onload = () => {
      readData(readUrl);
    };

    document.getElementById('getSession').addEventListener('click', () => {
      axios.get('../api/get_sessioon.php')
        .then(response => {
          // 成功した時
          console.log(response);
        })
    });
  </script>
</body>

</html>