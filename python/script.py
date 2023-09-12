import platform
from cpuinfo import get_cpu_info
import requests
import json
import psutil
import datetime

cpuinfo = get_cpu_info()

def Storage():
    disks = [];
    for disk in psutil.disk_partitions():
        disks.append({
            "name": disk.device,
            "memory": "{:.0f} GB".format(psutil.disk_usage(disk.device).total / (1024**3))
        })
    return disks

data =   {
            "Host": platform.node(),
            "SO": {
                    "name" :f"{platform.system()} {platform.release()}",
                    "arch" : cpuinfo['arch']
                },
            "Procesador": cpuinfo["brand_raw"],
            "RAM":"{:.0f} GB".format(psutil.virtual_memory().total / (1024**3)),
            "Storage": Storage(),
            "Hora del sistema": datetime.datetime.fromtimestamp(psutil.boot_time()).strftime("%Y-%m-%d %H:%M:%S")
        }
headers = {'Content-type': 'application/json', 'Accept': 'text/plain'}
response = requests.post('http://localhost:7777/api/computers', data=json.dumps(data), headers=headers)