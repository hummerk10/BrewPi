import os
import time
import MySQLdb

os.system('modprobe w1-gpio')
os.system('modprobe w1-therm')

db =MySQLdb.connect("localhost","root","mjwin101","brewery")

cur = db.cursor()

temp_sensor = '/sys/bus/w1/devices/28-0000058c9c71/w1_slave'

def temp_raw():

    f = open(temp_sensor, 'r')
    lines = f.readlines()
    f.close()
    return lines

def read_temp():

    lines = temp_raw()
    while lines[0].strip()[-3:] != 'YES':
        time.sleep(0.2)
        lines = temp_raw()


    temp_output = lines[1].find('t=')

    if temp_output != -1:
        temp_string = lines[1].strip()[temp_output+2:]
        temp_c = float(temp_string) / 1000.0
        temp_f = temp_c * 9.0 / 5.0 + 32.0
        return temp_f


while True:
        print(read_temp())
	try:
		cur.execute("""insert into temp (temp,datetime) values (%s,now());""",str(read_temp()))
		db.commit()
	except:
		db. rollback()



#        time.sleep(.5)
