# WMinecraft
Webshop Minecraft 99%

#<player> ใช้แทนชื่อผู้เล่น
#<and> ใช้คั่นคำสั่ง ในกรณีใช้หลายคำสั่งเช่นมี 2 คำสั่ง : say <player> ซื้อไอเทม<and>give <player> stone 1

ขั้นตอนการติดตั้ง
1.นำไฟล์เว็บลง folder htdocs (ของ Xampp)<br/>
2.ตั้งค่าการเชื่อมต่อฐานข้อมูล และ ที่อยู่เว็บที่ไฟล์ _config.php ใน โฟเดอร์ application<br/>
3.Import ไฟล์ WMinecraft SQL.sql ลงฐานข้อมูล โดย Database จะต้องเป็น utf8_general_ci หรือ utf8mb4_general_ci<br/>
4.Config ปลั๊กอิน authme ให้เชื่อมต่อกับฐานข้อมูล<br/>
5.เปิด server.propoties แล้ว enable-query ให้เป็น true แล้ว Save หาก Port ไม่ได้เป็น 25565 ให้เปลี่ยนเป็น 25565 นะครับ (ในอนาคตสามารถกำหนดเองได้นะครับ)<br/>

วิธีการตั้งให้ตัวเองเป็น Admin (ให้เข้าสู่ระบบหน้า Backend ได้)
1.เข้าไปที่ Database ที่เราสร้างขึ้น
2.ไปที่ Table authme
3.ตั้ง column: wm_rank_id ให้เป็น 2 ใน user ที่ต้องการให้เข้าสู่ระบบ Backend ได้
