package com.remedyserver

import org.springframework.boot.autoconfigure.SpringBootApplication
import org.springframework.boot.runApplication

@SpringBootApplication
class RemedyServerApplication

fun main(args: Array<String>) {
	runApplication<RemedyServerApplication>(*args)
}
