import os
import subprocess
import requests
import json
import psutil

# Global Variables
sysData = None

def systemData():
    sysData = os.popen('systeminfo').read()
    return sysData

def dataStorage():
    particion = psutil.disk_partitions()[0].device
    total_espacio = psutil.disk_usage(particion).total
    total_espacio_gb = total_espacio / (1024**3)
    return "{:.2f} GB".format(total_espacio_gb)

def dataRam(sysData):
    ram_info = subprocess.check_output(['systeminfo'], shell=True).decode('utf-8')
    total_ram = None
    for line in ram_info.splitlines():
        if "Total Physical Memory" in line:
            total_ram = line.split(":")[1].strip()
            break
    return total_ram

def dataSO(sysData):
    so_info = subprocess.check_output(['systeminfo'], shell=True).decode('utf-8')
    so = None
    for line in so_info.splitlines():
        if "OS Name" in line:
            so = line.split(":")[1].strip()
            break
    return so

if 1 == 1:
    sysData = systemData()
    storage_info = dataStorage()
    ram_info = dataRam(sysData)
    so_info = dataSO(sysData)   
    
    data = {
        "SO":so_info,
        "RAM":ram_info,
        "Storage":storage_info,
        }
    headers = {'Content-type': 'application/json', 'Accept': 'text/plain'}
    response = requests.post('http://localhost:7777/api/computers', data=json.dumps(data), headers=headers)