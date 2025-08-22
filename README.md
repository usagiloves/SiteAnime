# Live2D API

Live2D 看板娘插件 (https://www.fghrsh.net/post/123.html) 上使用的后端 API

### Đặc Trưng

- Phát triển PHP gốc, không  tĩnh,
- Hỗ trợ chuyển đổi tuần tự và chuyển đổi ngẫu nhiên các mô hình và giao diện
- Hỗ trợ chuyển đổi một mô hình duy nhất, nhiều giao diện đệ quy toàn diện
- Hỗ trợ chuyển đổi tải của nhiều mô hình hoặc nhiều đường dẫn trong cùng một nhóm
## Sử dụng

### Yêu cầu
- PHP  >= 5.2
- Phụ thuộc vào phần mở rông PHP ：json

### Cấu trúc

```shell
│  model_list.json              // Danh sách
│
├─model                         // Đường dẫn
│  └─GroupName                  // Nhóm modules
│      └─ModelName              // Tên
│
├─add                           // Cập nhật danh sách
├─get                           // Configs
├─rand                          // Chuyển đổi cấu hình
├─rand_textures                 // Chuyển giao diện
├─switch                     
├─switch_textures              
└─tools
        modelList.php           // Liệt kê các mô hình
        modelTextures.php       // Danh sách text
        name-to-lower.php       
```

### Thêm mô hình


```shell
│  index.json
│  model.moc
│  textures.cache       // 皮肤列表缓存，自动生成
│
├─motions
│      idle_01.mtn
│      idle_02.mtn
│      idle_03.mtn
│
└─textures
        default-costume.png
        school-costume.png
        winter-costume.png
```

```shell
│  index.json
│  model.moc
│  textures.cache
│  textures_order.json
│
├─motions
│      idle_01.mtn
│      idle_02.mtn
│      idle_03.mtn
│
├─texture_00
│      00.png
│
├─texture_01
│      00.png
│      01.png
│      02.png
│
├─texture_02
│      00.png
│      01.png
│      02.png
│
└─texture_03
       00.png
       01.png
```

textures_order.json

```json
[
    ["texture_00"],
    ["texture_01","texture_02"],
    ["texture_03"]
]
```

textures.cache

```json
[
    ["texture_00/00.png","texture_01/00.png","texture_02/00.png","texture_03/00.png"],
    ["texture_00/00.png","texture_01/00.png","texture_02/00.png","texture_03/01.png"],
    ["texture_00/00.png","texture_01/01.png","texture_02/01.png","texture_03/00.png"],
    ["texture_00/00.png","texture_01/01.png","texture_02/01.png","texture_03/01.png"],
    ["texture_00/00.png","texture_01/02.png","texture_02/02.png","texture_03/00.png"],
    ["texture_00/00.png","texture_01/02.png","texture_02/02.png","texture_03/01.png"]
]
```

```shell
│
├─model
│  ├─Group1
│  │  ├─Model1
│  │  │      index.json
│  │  │
│  │  └─Model2
│  │          index.json
│  │
│  ├─Group2
│  │  └─Model1
│  │          index.json
│  │
│  └─GroupName
│     └─ModelName
│          │  index.json
│          │  model.moc
│          │
│          ├─motions
│          └─textures
│
```

model_list.json
```json
{
    "models": [
        "GroupName/ModelName",
        [
            "Group1/Model1",
            "Group1/Model2",
            "Group2/Model1"
        ]
    ],
    "messages": [
        "Example 1",
        "Example 2"
    ]
}
```

### Sử dụng
- `/add/` - Phát hiện giao diện và cập nhật danh sách
- `/get/?id=1-23` Nhận waifu số 23 cho nhóm 1
- `/rand/?id=1` Chuyển đổi ngẫu nhiên 
- `/switch/?id=1` Chuyển theo thứ tự


