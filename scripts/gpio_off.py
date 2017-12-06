# To turn on pin 4: python gpio.py 4 0
# To turn off pin 4: python gpio.py 4 1
import RPi.GPIO as GPIO
import time

GPIO.setmode(GPIO.BCM)
GPIO.setup(4, GPIO.OUT)
GPIO.setup(17, GPIO.OUT)
GPIO.setup(22, GPIO.OUT)
GPIO.setup(10, GPIO.OUT)
GPIO.output(4, True)
GPIO.output(17, True)
GPIO.output(22, True)
GPIO.output(10, True)
time.sleep(1)