def slope(point1, point2, absolute=False):
    x1,y1 = point1
    x2,y2 = point2
    deltaX = x2-x1
    deltaY = y2-y1
    if deltaX == 0:
        return "inf"
    slope = deltaY / deltaX
    if absolute:
        slope = abs(slope)
    return round(slope,3)