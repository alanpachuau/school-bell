# To turn on pin 4: python gpio.py 4 0
# To turn off pin 4: python gpio.py 4 1
import sys
import RPi.GPIO as GPIO
import time

pin = int(sys.argv[1])
state = int(sys.argv[2])
GPIO.setmode(GPIO.BCM)
GPIO.setup(pin, GPIO.OUT)

if state == 1:
        GPIO.output(pin, True)
else:
        GPIO.output(pin, False)
time.sleep(1)