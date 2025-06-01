import re
import os

CATS = {
    'box': '宝箱',
    'fashion': '时装',
    'card': '卡',
    'illustration': '图鉴',
    'pack': '礼包',
    'gem': '宝石',
    'title': '称号',
    'item': ''
}

with open('globaldata.sql', 'r', encoding='utf-8') as f:
    data = f.read()

match = re.search(r"INSERT INTO `itemblist` VALUES (.*?);", data)
if not match:
    raise SystemExit('itemblist not found')
values_str = match.group(1)
rows = re.split(r"\),\(", values_str.strip('()'))

cat_files = {k: open(os.path.join('gm/onekey', f'item_{k}.txt'), 'w', encoding='utf-8') for k in CATS}

for row in rows:
    parts = []
    buf = ''
    in_quote = False
    for ch in row:
        if ch == "'":
            in_quote = not in_quote
            buf += ch
        elif ch == ',' and not in_quote:
            parts.append(buf)
            buf = ''
        else:
            buf += ch
    parts.append(buf)
    if len(parts) >= 3:
        try:
            itemid = int(parts[1])
            name = parts[2].strip("'")
        except ValueError:
            continue
        written = False
        for cat, keyword in CATS.items():
            if cat == 'item':
                continue
            if keyword and keyword in name:
                cat_files[cat].write(f'{itemid};{name}\n')
                written = True
                break
        if not written:
            cat_files['item'].write(f'{itemid};{name}\n')

for f in cat_files.values():
    f.close()
