
 
; PROGRAM CAN READ NUMBERS FROM 0 TO 129  










org 100h

.data
prompt dw "Enter a number $" 13, 10
evenMsg dw " Even number $"    
oddMsg dw " Odd number $"
temp db 10d
userNumber db ?
.code    

main proc
    mov ax, @data
    mov ds,ax            
    lea dx, prompt 
    mov ah,09h
    mov al, 00h
    int 21h
    mov ah, 1
    int 21h
    sub al, 48d
    mov dl, al
    
    input:
    mov ah, 1
    int 21h
    cmp al, 13d
    je setReg
    sub al, 48d
    mov cl, al
    mov al, dl
    mul temp
    add al, cl
    mov dl, al
    jmp input
    
    
    setReg:
    or ax , -1
    mov al, dl
    mov bl, dl
    mov userNumber, dl
    cmp al, 0d
    je even           
    reduce:   
    sub al, 2h
    jz even
    js odd
    cmp al, 1
    jz odd
    jmp reduce
    
    even:
    lea bx, evenMsg
    jmp result
    
    odd:
    lea bx, oddMsg
    
    result:
    mov dl, 10
    mov ah, 02h
    int 21h
    mov dl, 13
    mov ah, 02h
    int 21h
    mov dx, bx 
    mov ah, 09h   
    int 21h
    
    endprogram:
    mov ah, 01h
    int 21h
    sub al, 48d
    jne endprogram   
 
    main endp
end main

ret




