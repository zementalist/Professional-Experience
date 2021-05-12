
org 100h

.data  

arr1 db 2,4,6,8
arr2 db 1,3,5,7,9, 4 dup(?)



arr1size db 4
arr2size db 9

.code



main PROC
    ; clear Registers
    call clearRegisters
    
    ; Keep arrays sizes
    mov cl, arr1size
    mov bl, arr2size
    
    ; append last by last
    append:
    dec cl
    js finished ; reached index[-1]
    dec bl
    mov si, cx
    mov al, arr1[si]
    mov si, bx
    mov arr2[si], al
    jns append
    
    finished:
    call display_array
    
    
    ret
main endp
   


display_array PROC
    ; Clear Registers
    call clearRegisters
	
	; Keep array size
    mov bl, arr2size 
    
    ; Loop over array
    get_next_item:
        mov si, cx
        mov dl, arr2[si]
        add dl, 48d
        inc cl
        mov ah, 02h
        int 21h
        cmp cl, bl
        jne get_next_item 
    or ax , -1    
    ret
display_array endp
   
clearRegisters PROC
    mov ax, 0000h
	mov bx, 0000h
	mov cx, 0000h
	mov dx, 0000h
    ret
clearRegisters endp
   
end main    






