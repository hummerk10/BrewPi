# Initialize
# Display IP address and wait for inputs. 
# Turn on Boil Term
# Turn key to start timer

#import

import RPi.GPIO as GPIO
import socket, fcntl, struct
import os
import time
import MySQLdb
 
# Define GPIO to LCD mapping
LCD_RS = 7
LCD_E  = 8
LCD_D4 = 25
LCD_D5 = 24
LCD_D6 = 23
LCD_D7 = 18
#LED_ON = 15
 
# Define some device constants
LCD_WIDTH = 20    # Maximum characters per line
LCD_CHR = True
LCD_CMD = False
 
LCD_LINE_1 = 0x80 # LCD RAM address for the 1st line
LCD_LINE_2 = 0xC0 # LCD RAM address for the 2nd line
LCD_LINE_3 = 0x94 # LCD RAM address for the 3rd line
LCD_LINE_4 = 0xD4 # LCD RAM address for the 4th line
 
# Timing constants
E_PULSE = 0.0005
E_DELAY = 0.0005
 
def main():
  # Main program block
 
  GPIO.setmode(GPIO.BCM)       # Use BCM GPIO numbers
  GPIO.setup(LCD_E, GPIO.OUT)  # E
  GPIO.setup(LCD_RS, GPIO.OUT) # RS
  GPIO.setup(LCD_D4, GPIO.OUT) # DB4
  GPIO.setup(LCD_D5, GPIO.OUT) # DB5
  GPIO.setup(LCD_D6, GPIO.OUT) # DB6
  GPIO.setup(LCD_D7, GPIO.OUT) # DB7
  #GPIO.setup(LED_ON, GPIO.OUT) # Backlight enable
  GPIO.setup(15, GPIO.IN, pull_up_down=GPIO.PUD_UP) # KEY SW
  GPIO.setup(26, GPIO.IN, pull_up_down=GPIO.PUD_UP) # Boil SW
  GPIO.setup(19, GPIO.IN, pull_up_down=GPIO.PUD_UP) # Mash SW
  GPIO.setup(13, GPIO.IN, pull_up_down=GPIO.PUD_UP) # Liquor SW
  
  GPIO.setup(12, GPIO.OUT) # Element 1
  # Initialise display
  lcd_init()
  
  
 
  db =MySQLdb.connect("localhost","root","mjwin101","brewery")
  cur = db.cursor()

  my_ip = getifip('wlan0')
  
  i=0
  n=0


  while True:
    time.sleep(1)
    Key_state = GPIO.input(15) #  if key switch is flipped
    Boil_state = GPIO.input(26) #  if Boil switch is flipped
    Mash_state = GPIO.input(19) #  if Mash switch is flipped
    Liquor_state = GPIO.input(13) #  if Liquor switch is flipped
    print "Key"
    print Key_state
    
    if Key_state == True:
      my_ip = getifip('wlan0')
      # Send some centred test
      lcd_string("Please Configure at",LCD_LINE_1,2)
      lcd_string(" ",LCD_LINE_2,2)
      lcd_string("http://"+my_ip,LCD_LINE_3,2)
      lcd_string("--------------------",LCD_LINE_4,2)
    
    else:    
      print'Key Switched'
      
      Mfile = open("/sys/bus/w1/devices/28-800000044e56/w1_slave")
      Lfile = open("/sys/bus/w1/devices/28-8000001ec5a0/w1_slave")
      Pfile = open("/sys/bus/w1/devices/28-8000001f1360/w1_slave")
                  
      # Read all of the text in the file.
      Ptext = Pfile.read()
      Mtext = Mfile.read()
      Ltext = Lfile.read()
        # Close the file now that the text has been read.
      Pfile.close()
      Mfile.close()
      Lfile.close()
       # Split the text with new lines (\n) and select the second line.
      Psecondline = Ptext.split("\n")[1]
      Msecondline = Mtext.split("\n")[1]
      Lsecondline = Ltext.split("\n")[1]

        # Split the line into words, referring to the spaces, and select the 10th word (counting from 0).
      Ptemperaturedata = Psecondline.split(" ")[9]
      Mtemperaturedata = Msecondline.split(" ")[9]
      Ltemperaturedata = Lsecondline.split(" ")[9]

        # The first two characters are "t=", so get rid of those and convert the temperature from a string to a number.
      Ptemperature = float(Ptemperaturedata[2:])
      Mtemperature = float(Mtemperaturedata[2:])
      Ltemperature = float(Ltemperaturedata[2:])

        # Put the decimal point in the right place and display it.
      Ptemperature = Ptemperature / 1000
      Ptemperature = (Ptemperature * 1.8) + 32
      print "Boil"
      print Boil_state
      
      if Boil_state == False:
            print "Boil"
            try:
                cur.execute("""insert into temp (temp,datetime,Point) values (%s,now(),"0");""",str(Ptemperature))
                db.commit()
            except:
                db. rollback()
            print Ptemperature

      Mtemperature = Mtemperature / 1000
      Mtemperature = (Mtemperature * 1.8) + 32
      print "Mash"
      print Mash_state
      
      if Mash_state == False:
            print "Mash"
            try:
                cur.execute("""insert into temp (temp,datetime,Point) values (%s,now(),"1");""",str(Mtemperature))
                db.commit()
            except:
                db. rollback()
            print Mtemperature

      Ltemperature = Ltemperature / 1000
      Ltemperature = (Ltemperature * 1.8) + 32
      print "Liquor"
      print Liquor_state
           
      if Liquor_state == False:
            print "Liquor"
            GPIO.output(12, GPIO.HIGH)
            try:
                cur.execute("""insert into temp (temp,datetime,Point) values (%s,now(),"2");""",str(Ltemperature))
                db.commit()
            except:
                db. rollback()
            print Ltemperature

      if Liquor_state == True:
            GPIO.output(12, GPIO.LOW)

      lcd_string("Step:",LCD_LINE_1,2)
      lcd_string("Time:",LCD_LINE_2,2)
      lcd_string("Input:",LCD_LINE_3,2)
      lcd_string("Temp:",LCD_LINE_4,2)
 
   

 
def lcd_init():
  # Initialise display
  lcd_byte(0x33,LCD_CMD) # 110011 Initialise
  lcd_byte(0x32,LCD_CMD) # 110010 Initialise
  lcd_byte(0x06,LCD_CMD) # 000110 Cursor move direction
  lcd_byte(0x0C,LCD_CMD) # 001100 Display On,Cursor Off, Blink Off
  lcd_byte(0x28,LCD_CMD) # 101000 Data length, number of lines, font size
  lcd_byte(0x01,LCD_CMD) # 000001 Clear display
  time.sleep(E_DELAY)
 
def lcd_byte(bits, mode):
  # Send byte to data pins
  # bits = data
  # mode = True  for character
  #        False for command
 
  GPIO.output(LCD_RS, mode) # RS
 
  # High bits
  GPIO.output(LCD_D4, False)
  GPIO.output(LCD_D5, False)
  GPIO.output(LCD_D6, False)
  GPIO.output(LCD_D7, False)
  if bits&0x10==0x10:
    GPIO.output(LCD_D4, True)
  if bits&0x20==0x20:
    GPIO.output(LCD_D5, True)
  if bits&0x40==0x40:
    GPIO.output(LCD_D6, True)
  if bits&0x80==0x80:
    GPIO.output(LCD_D7, True)
 
  # Toggle 'Enable' pin
  lcd_toggle_enable()
 
  # Low bits
  GPIO.output(LCD_D4, False)
  GPIO.output(LCD_D5, False)
  GPIO.output(LCD_D6, False)
  GPIO.output(LCD_D7, False)
  if bits&0x01==0x01:
    GPIO.output(LCD_D4, True)
  if bits&0x02==0x02:
    GPIO.output(LCD_D5, True)
  if bits&0x04==0x04:
    GPIO.output(LCD_D6, True)
  if bits&0x08==0x08:
    GPIO.output(LCD_D7, True)
 
  # Toggle 'Enable' pin
  lcd_toggle_enable()
 
def getifip(ifn):
    sck = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    return socket.inet_ntoa(fcntl.ioctl(sck.fileno(),0x8915, struct.pack('256s', ifn[:15]))[20:24])
 
def lcd_toggle_enable():
  # Toggle enable
  time.sleep(E_DELAY)
  GPIO.output(LCD_E, True)
  time.sleep(E_PULSE)
  GPIO.output(LCD_E, False)
  time.sleep(E_DELAY)
 
def lcd_string(message,line,style):
  # Send string to display
  # style=1 Left justified
  # style=2 Centred
  # style=3 Right justified
 
  if style==1:
    message = message.ljust(LCD_WIDTH," ")
  elif style==2:
    message = message.center(LCD_WIDTH," ")
  elif style==3:
    message = message.rjust(LCD_WIDTH," ")
 
  lcd_byte(line, LCD_CMD)
 
  for i in range(LCD_WIDTH):
    lcd_byte(ord(message[i]),LCD_CHR)
 
def lcd_backlight(flag):
  # Toggle backlight on-off-on
  GPIO.output(LED_ON, flag)
 
if __name__ == '__main__':
 
  try:
    main()
  except KeyboardInterrupt:
    pass
  finally:
    lcd_byte(0x01, LCD_CMD)
    lcd_string("Goodbye!",LCD_LINE_1,2)
    GPIO.cleanup()
