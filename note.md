Cara commit ke github:
1. jika belum menghubungkan ke repo maka:
    `git remote add origin LINK_GITHUB`
2. cek apakah repo sudah terhubung:
    `git remote -v`
3. tambahkan perubahan ke repo local:
    `git add .`
4. commit repo local:
    `git commit -m "message"`
5. push repo local ke repo github:
    `git push origin main`